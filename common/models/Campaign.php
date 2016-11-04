<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property string $name
 * @property integer $discount
 * @property integer $coupon_action_time
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Coupon[] $coupons
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'discount', 'coupon_action_time'], 'required'],
            [['discount', 'coupon_action_time', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
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
            'name' => 'Name',
            'discount' => 'Discount',
            'coupon_action_time' => 'Coupon Action Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['campaign_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\CampaignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\CampaignQuery(get_called_class());
    }
}
