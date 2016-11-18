<?php

namespace common\models;

use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
            ['amount', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'item_ID',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @param $event Event
     * @return bool
     */
    public function changeAmount($event)
    {
        $order = $event->sender;
        if ($order->status == Order::ORDER_DONE) {
            $items = $order->getValue();
            foreach ($items as $item) {
                $item_size = self::find()->where(['item_id' => $item->id, 'size_id' => $item->size])->one();
                if ($item_size) {
                    $item_size->amount = max(0, $item_size->amount - $item->quantity);
                    $item_size->save(false);
                }
            }
        }
        return true;
    }

    /**
     * @param $item Item
     * @return array|bool
     */
    public static function getUnavailableSize($item)
    {
        $size_table = $item->getSizeTable();

        $item_sizes = ItemSize::find()
            ->select('size_id')
            ->where(['item_id' => $item->id])
            ->andWhere(['>', 'amount', 0])
            ->asArray()
            ->column();

        $result = array_flip(
            array_diff(
                array_flip(
                    ArrayHelper::map($size_table, 'id', 'value')
                ),
                $item_sizes
            )
        );

        if (empty($result)) {
            return false;
        }

        return $result;
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
