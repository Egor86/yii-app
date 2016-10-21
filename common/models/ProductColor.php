<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_color".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property string $name
 * @property string $slug
 * @property string $stock_keeping_unit
 * @property integer $price
 * @property integer $discount_price
 */
class ProductColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id', 'name', 'slug', 'stock_keeping_unit', 'price'], 'required'],
            [['product_id', 'color_id', 'price', 'discount_price'], 'integer'],
            [['name', 'slug', 'stock_keeping_unit'], 'string', 'max' => 45],
            [['stock_keeping_unit'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'color_id' => 'Color ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'stock_keeping_unit' => 'Stock Keeping Unit',
            'price' => 'Price',
            'discount_price' => 'Discount Price',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductColorQuery(get_called_class());
    }
}
