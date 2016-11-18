<?php

namespace common\models;

use common\models\active_query\CouponQuery;
use frontend\models\MailSender;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $coupon_code
 * @property integer $subscriber_id
 * @property integer $campaign_id
 * @property string $using_status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property integer $expiry_date
 *
 * @property Campaign $campaign
 * @property Subscriber $subscriber
 */
class Coupon extends \yii\db\ActiveRecord
{
    const USED = 1;
    const UNUSED = 0;
    const COUPON_CODE_LENGTH = 6;
    const EVENT_GET_COUPON = 'generateCouponCode';

    public $email;
    public $phone;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coupon_code', 'subscriber_id'
//                ,'email', 'phone',
            ], 'required'],
            [['subscriber_id', 'campaign_id', 'created_at', 'updated_at', 'sort_by', 'using_status', 'expiry_date'], 'integer'],
            [['coupon_code', 'email'], 'string', 'max' => 45],
            ['phone', 'string', 'max' => 15],
            [['coupon_code'], 'unique'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
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
            'expiry_date' => 'Expiry Date',
        ];
    }
//
//    public function scenarios()
//    {
//        $scenarios = parent::scenarios();
//        $scenarios['verife_coupon'] = ['email', 'phone', 'coupon_code'];
//        return $scenarios;
//    }

    /**
     * If no one Campaign is ACTIVE throw Exception
     * @param $event Event
     * @return bool
     * @throws Exception
     */
    public function createCoupon($event)
    {
        $this->subscriber_id = $event->sender->id;
        if (!$campaign = Campaign::findOne(['status' => Campaign::CAMPAIGN_ACTIVE])) {
            throw new Exception('Извините, по техническим причинам операцию выполнить невозможно, пожалуйста, попробуйте позже!');
        }

        $this->campaign_id = $campaign->id;
        $this->expiry_date = 0;
        if ($campaign->coupon_action_time) {
            $this->expiry_date = time() + $campaign->coupon_action_time;
        }

        $this->coupon_code = $this->generateCouponCode();

        if (!$this->save()) {
            return false;
        }

        MailSender::sendEmail(
            $event->sender->email,
            'Купон на скидку - ' . $campaign->discount . ' грн от интернет-магазина ego-ist.me',
            $this->coupon_code, 'coupon-html');

        return true;
    }

    protected function generateCouponCode()
    {
        $id = self::find()->select('id')->orderBy(['id' => SORT_DESC])->asArray()->limit(1)->column();
        $id = !empty($id) ? $id[0] += 1 : 1;
        $code = date('m') * date("Y") . '-' . sprintf("%'.03d", $id);
        return $code;
    }

    /**
     * @param $event Event
     * @return bool
     */
    public function changeStatus($event)
    {
        if ($event->sender->status == Order::ORDER_REVOKED && $event->sender->coupon_id) {
            $coupon = self::findOne($event->sender->coupon_id);
            if ($coupon) {
                $coupon->using_status = self::UNUSED;
                $coupon->save(false);
            }
        }
        return true;
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
