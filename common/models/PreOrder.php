<?php

namespace common\models;

use frontend\models\MailSender;
use Yii;

/**
 * This is the model class for table "pre_order".
 *
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $item_id
 * @property integer $size_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $name
 * @property string $email
 * @property string $phone
 *
 * @property Item $item
 * @property Size $size
 */
class PreOrder extends \yii\db\ActiveRecord
{
    const STATUS_PROGRESS = 0;
    const STATUS_DONE = 1;

//    public function init()
//    {
//        parent::init();
//        $this->on(Subscriber::EVENT_NEW_SUBSCRIBER, [new Subscriber(), 'createSubscriber'], Subscriber::GROUP_PRE_ORDER);
//    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_order';
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//        if ($insert) {
//            $this->trigger(Subscriber::EVENT_NEW_SUBSCRIBER);
//
//            MailSender::sendEmail(
//                $this->email,
//                'Предзаказ товара - ' . $this->item->name,
//                'Как только появится товар - ' . $this->item->name . 'мы Вам сообщим', 'pre_order-html');
//        }
//        return true;
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'name', 'phone'], 'required'],
            [['item_id', 'size_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'email'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
            ['status', 'default', 'value' => self::STATUS_PROGRESS],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::className(), 'targetAttribute' => ['size_id' => 'id']],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Артикул / название товара',
            'size_id' => 'Размер',
            'created_at' => 'Создан',
            'updated_at' => 'Updated At',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон (моб)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
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
