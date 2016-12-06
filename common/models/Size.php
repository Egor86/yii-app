<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "size".
 *
 * @property integer $id
 * @property string $value
 * @property integer $size_table_name_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductColorSize[] $productColorSizes
 * @property SizeTableName $sizeTableName
 */
class Size extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'size';
    }

    public static function getCount($product_id)
    {
        return self::find()
            ->where(['size_table_name_id' => Product::findOne($product_id)->category->size_table_name_id])
            ->count();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'size_table_name_id'], 'required'],
            [['size_table_name_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 15],
            [['size_table_name_id'], 'exist', 'skipOnError' => true, 'targetClass' => SizeTableName::className(), 'targetAttribute' => ['size_table_name_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Размер',
            'size_table_name_id' => 'Название таблицы размеров',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'sizeTableName.name' => 'Название таблицы размеров'
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
     * @return \yii\db\ActiveQuery
     */
    public function getProductColorSizes()
    {
        return $this->hasMany(ProductColorSize::className(), ['size_id' => 'id'])->inverseOf('size');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizeTableName()
    {
        return $this->hasOne(SizeTableName::className(), ['id' => 'size_table_name_id'])->inverseOf('sizes');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\SizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\SizeQuery(get_called_class());
    }
}
