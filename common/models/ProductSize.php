<?php

namespace common\models;

use voskobovich\behaviors\ManyToManyBehavior;
use Yii;

/**
 * This is the model class for table "product_size".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $size_id
 * @property integer $amount
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProductSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'size_id'], 'required'],
            [['product_id', 'size_id', 'amount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['color_ids'], 'each', 'rule' => ['integer']],
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
            'size_id' => 'Size ID',
            'amount' => 'Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'color_ids' => 'colors',
                ],
            ],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'id']);
    }

    public function getSize()
    {
        return $this->hasOne(Size::className(), ['size_id' => 'id']);
    }

    public function getColors()
    {
        return $this->hasMany(Color::className(), ['id' => 'color_id'])
            ->viaTable(ProductSizeColor::tableName(),['product_size_id' => 'id']);
    }



    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductSizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductSizeQuery(get_called_class());
    }
}
