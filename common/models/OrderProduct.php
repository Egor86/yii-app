<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_product".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $color_id
 * @property integer $size_id
 *
 * @property Order $order
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'color_id', 'size_id'], 'required'],
            [['order_id', 'product_id', 'color_id', 'size_id', 'amount'], 'integer'],
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
            'product_id' => 'Название товара',
            'color_id' => 'Цвет',
            'size_id' => 'Размер',
            'price' => 'Цена',
            'amount' => 'Количество',
            'total' => 'Итоговая сумма',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id'])->inverseOf('orderProducts');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }

    public function getTotal()
    {
        $discount = Coupon::findOne($this->order->coupon_id);
        $order_products = self::find()->where(['order_id' => $this->order_id])->asArray()->all();
        $total_price = null;
        for ($i = 0; $i < count($order_products); $i++){
            $product = Product::findOne($order_products[$i]['product_id']);
            $price_per_item = $product->price;
            if ($product->discount_price){
                $price_per_item = $product->discount_price;
            }
            $total_price += $order_products[$i]['amount'] * $price_per_item;
        }
        return $total_price - ($discount === null ? null : $discount->discount);
    }


    /**
     * @inheritdoc
     * @return \common\models\active_query\OrderProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\OrderProductQuery(get_called_class());
    }
}
