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
    const CAMPAIGN_ACTIVE = 1;
    const CAMPAIGN_CLOSED = 0;

    public static function getStatus()
    {
        return [
            self::CAMPAIGN_CLOSED => 'Закрыта',
            self::CAMPAIGN_ACTIVE => 'Активная'
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->status == self::CAMPAIGN_ACTIVE) {
                Campaign::updateAll(['status' => self::CAMPAIGN_CLOSED]);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'discount', 'coupon_action_time'], 'required'],
            [['discount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 45],
            ['coupon_action_time', 'actionTimeCreate']
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
            'name' => 'Название',
            'discount' => 'Сумма скидки',
            'coupon_action_time' => 'Срок действия скидки',
            'status' => 'Статус',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    public function actionTimeCreate($attribute)
    {
        $this->coupon_action_time = (($this->coupon_action_time['day'] * 24 + $this->coupon_action_time['hour']) *
                60 + $this->coupon_action_time['minute']) * 60;
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
