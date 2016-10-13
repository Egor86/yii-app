<?php

namespace common\models;

use backend\models\OrderStatus;
use common\models\active_query\FastOrderQuery;
use Yii;

/**
 * This is the model class for table "fast_order".
 *
 * @property integer $id
 * @property string $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order_status_id
 *
 * @property OrderStatus $orderStatus
 */
class FastOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fast_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'order_status_id'], 'required'],
            [['created_at', 'updated_at', 'order_status_id'], 'integer'],
            [['phone'], 'string', 'max' => 10],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['order_status_id' => 'id']],
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
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'order_status_id' => 'Order Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'order_status_id']);
    }

    /**
     * @inheritdoc
     * @return FastOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FastOrderQuery(get_called_class());
    }
}
