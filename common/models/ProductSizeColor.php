<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_size_color".
 *
 * @property integer $id
 * @property integer $product_size_id
 * @property integer $color_id
 */
class ProductSizeColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_size_color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_size_id', 'color_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_size_id' => 'Product Size ID',
            'color_id' => 'Color ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductSizeColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductSizeColorQuery(get_called_class());
    }
}
