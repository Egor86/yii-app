<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_order".
 *
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $product_id
 * @property integer $color_id
 * @property integer $size_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Subscriber $subscriber
 */
class PreOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'product_id', 'color_id', 'size_id', 'created_at', 'updated_at'], 'required'],
            [['subscriber_id', 'product_id', 'color_id', 'size_id', 'created_at', 'updated_at'], 'integer'],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscriber_id' => 'Subscriber ID',
            'product_id' => 'Product ID',
            'color_id' => 'Color ID',
            'size_id' => 'Size ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(Subscriber::className(), ['id' => 'subscriber_id'])->inverseOf('preOrders');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\PreOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\PreOrderQuery(get_called_class());
    }
}
