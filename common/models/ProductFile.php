<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_file".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $file_id
 *
 * @property Product $product
 */
class ProductFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'file_id'], 'required'],
            [['product_id', 'file_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'file_id' => 'File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->inverseOf('productFiles');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductFileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductFileQuery(get_called_class());
    }
}
