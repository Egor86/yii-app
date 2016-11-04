<?php

namespace common\models;

use backend\models\Campaign;
use common\models\active_query\CouponQuery;
use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $coupon_code
 * @property integer $subscriber_id
 * @property integer $campaign_id
 * @property string $using_status
 * @property integer $discount
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 *
 * @property Campaign $campaign
 * @property Subscriber $subscriber
 */
class Coupon extends \yii\db\ActiveRecord
{
    const USED = 1;
    const UNUSED = 0;
    const COUPON_CODE_LENGTH = 6;
    const EVENT_GET_COUPON = 'generate coupon code';

    public $email;
    public $phone;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            // send email with coupon code
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_code', 'subscriber_id','email', 'phone',], 'required'],
            [['subscriber_id', 'campaign_id', 'created_at', 'updated_at', 'sort_by', 'discount', 'using_status'], 'integer'],
            [['coupon_code', 'email'], 'string', 'max' => 45],
            ['phone', 'string', 'max' => 15],
            [['coupon_code'], 'unique'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
            ['campaign_id', 'default', 'value' => 1],
            ['using_status', 'default', 'value' => self::UNUSED]
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coupon_code' => 'Код купона',
            'subscriber_id' => 'Subscriber ID',
            'campaign_id' => 'Campaign ID',
            'using_status' => 'Using Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort_by' => 'Sort By',
            'phone' => 'Телефон(моб)',
            'discount' => 'Скидка',
        ];
    }
//
//    public function scenarios()
//    {
//        $scenarios = parent::scenarios();
//        $scenarios['verife_coupon'] = ['email', 'phone', 'coupon_code'];
//        return $scenarios;
//    }

    public function createCoupon($event)
    {
        $this->subscriber_id = $event->sender->id;
        $this->coupon_code = $this->generateCouponCode();
        $this->save();
    }

    public function generateCouponCode()
    {
        $existed_code = self::find()->select('coupon_code')->asArray()->column();
        $arr = ['a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0'
//            ,'.',',',
//            '(',')','[',']','!','?',
//            '&','^','%','@','*','$',
//            '<','>','/','|','+','-',
//            '{','}','`','~'
        ];
        $code = "";
        do {
            for($i = 0; $i < self::COUPON_CODE_LENGTH; $i++)
            {
                $index = mt_rand(0, count($arr) - 1);
                $code .= $arr[$index];
            }
        } while (in_array($code, $existed_code));

        return $code;
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(Subscriber::className(), ['id' => 'subscriber_id']);
    }

    /**
     * @inheritdoc
     * @return CouponQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CouponQuery(get_called_class());
    }
}
