<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_color_size".
 *
 * @property integer $id
 * @property integer $product_color_id
 * @property integer $size_id
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 */
class ProductColorSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_color_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_color_id', 'size_id'], 'required'],
            [['product_color_id', 'size_id', 'amount', 'created_at', 'updated_at'], 'integer'],
            ['size_id', 'unique', 'targetAttribute' => ['product_color_id', 'size_id']],
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


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['size_id', 'amount'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_color_id' => 'Product Color ID',
            'size_id' => 'Размер',
            'amount' => 'Kоличество',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'color' => 'Цвет'
        ];
    }

    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }

    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id'])
            ->viaTable(ProductColor::tableName(), ['id' => 'product_color_id']);
    }
    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductColorSizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductColorSizeQuery(get_called_class());
    }
}
