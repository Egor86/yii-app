<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property string $id
 * @property integer $order_id
 * @property string $name
 * @property string $value
 * @property integer $status
 *
 * @property Order $order
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'name', 'value'], 'required'],
            [['order_id', 'status'], 'integer'],
            [['value'], 'string'],
            [['id', 'name'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'name' => 'Name',
            'value' => 'Value',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id'])->inverseOf('carts');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\CartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\CartQuery(get_called_class());
    }
}
