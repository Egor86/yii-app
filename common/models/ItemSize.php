<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_size".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $size_id
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Size $size
 */
class ItemSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size_id'], 'required'],
            [['item_id', 'size_id', 'amount', 'created_at', 'updated_at'], 'integer'],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::className(), 'targetAttribute' => ['size_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Product Color ID',
            'size_id' => 'Размер',
            'amount' => 'Количество',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id'])->inverseOf('itemSizes');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ItemSizeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ItemSizeQuery(get_called_class());
    }
}
