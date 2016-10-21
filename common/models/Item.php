<?php

namespace common\models;

use common\behavior\SeoBehavior;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property string $name
 * @property string $slug
 * @property string $stock_keeping_unit
 * @property string $price
 * @property string $discount_price
 * @property integer $created_at
 * @property integer $updated_at
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id', 'name', 'slug', 'stock_keeping_unit', 'price'], 'required'],
            [['product_id', 'color_id'], 'integer'],
            [['price', 'discount_price'], 'number'],
            [['name', 'slug', 'stock_keeping_unit'], 'string', 'max' => 45],
            ['slug', 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => 'URL может состоять из латиницы и тире'],
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
            'color_id' => 'Цвет',
            'name' => 'Наименование',
            'slug' => 'URL',
            'stock_keeping_unit' => 'Артикул',
            'price' => 'Цена',
            'discount_price' => 'Цена со скидкой',
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
            'seoBehavior' => SeoBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ItemQuery(get_called_class());
    }
}
