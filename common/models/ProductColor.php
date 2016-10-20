<?php

namespace common\models;

use voskobovich\behaviors\ManyToManyBehavior;
use Yii;

/**
 * This is the model class for table "product_color".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
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
            [['product_id', 'color_id'], 'required'],
            [['product_id', 'color_id'], 'integer'],
//            [['product_id', 'color_id'], 'unique'],
//            ['color_id', 'unique', 'targetAttribute' => ['product_id', 'color_id']],
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
            'color_ids' => Yii::t('backend', 'Цвета'),
            'productName' => Yii::t('backend', 'Наименование товара'),
            'color' => Yii::t('backend', 'Цвет'),
            'amount' => Yii::t('backend', 'Количество'),
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            ProductColorSize::deleteAll(['product_color_id' => $this->id]);
            return true;
        }
        return false;
    }

    public function getColors()
    {
        return $this->hasMany(Color::className(), ['id' => 'color_id']);
    }

    /**
     * for ProductColorController actionUpdate
     * @return \yii\db\ActiveQuery
     */
    public function getProductColorSizes()
    {
        return $this->hasMany(ProductColorSize::className(), ['product_color_id' => 'id']);
    }

//    public function getSize()
//    {
//        return $this->hasOne(ProductColorSize::className(), ['product_color_id' => 'id'])
////            ->viaTable('product_color_size', ['product_color_id' => 'id'])
//            ;
//    }
//
    public function getSizes()
    {
        return $this->hasMany(ProductColorSize::className(), ['product_color_id' => 'id']);
    }
//
//    public function getAmount()
//    {
//        return $this->hasOne(ProductColorSize::className(), ['product_color_id' => 'id']);
//    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductColorQuery(get_called_class());
    }
}
