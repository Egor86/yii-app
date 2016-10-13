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
            [['coupon_code', 'subscriber_id'], 'required'],
            [['subscriber_id', 'campaign_id', 'created_at', 'updated_at', 'sort_by', 'discount', 'using_status'], 'integer'],
            [['coupon_code'], 'string', 'max' => 45],
            [['coupon_code'], 'unique'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
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
            'coupon_code' => 'Coupon Code',
            'subscriber_id' => 'Subscriber ID',
            'campaign_id' => 'Campaign ID',
            'using_status' => 'Using Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort_by' => 'Sort By',
        ];
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
