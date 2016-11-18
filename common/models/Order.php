<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $address
 * @property string $organization_name
 * @property string $post_index
 * @property string $phone
 * @property string $email
 * @property string $delivery_date
 * @property integer $coupon_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property string $value
 * @property string $comment
 * @property integer $total_cost
 *
 * @property OrderProduct[] $orderProducts
 */
class Order extends \yii\db\ActiveRecord
{
    const ORDER_FAST = 0;
    const ORDER_NEW = 1;
    const ORDER_PROCESSED = 2;
    const ORDER_REVOKED = 3;
    const ORDER_DONE = 4;

    const EVENT_CHANGE_STATUS = 'changeUsingStatus';

    public function __construct($coupon_id = false, array $config = [])
    {
        if ($coupon_id && $coupon = Coupon::findOne($coupon_id)) {
            $this->coupon_id = $coupon->id;
            $this->email = $coupon->subscriber->email;
            $this->phone = $coupon->subscriber->phone;
            $this->name = $coupon->subscriber->name;
        }
        parent::__construct($config);
    }


    public function init()
    {
        parent::init();
        $this->on(self::EVENT_CHANGE_STATUS, [new Coupon(), 'changeStatus']);
        $this->on(self::EVENT_CHANGE_STATUS, [new ItemSize(), 'changeAmount']);
        $this->on(Subscriber::EVENT_NEW_SUBSCRIBER, [new Subscriber(), 'createSubscriber'], Subscriber::GROUP_ORDER);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public static function getStatus()
    {
        return [
            self::ORDER_FAST        => 'Быстрый заказ',
            self::ORDER_NEW         => 'Новый',
            self::ORDER_PROCESSED   => 'В процессе',
            self::ORDER_REVOKED     => 'Отменен',
            self::ORDER_DONE        => 'Завершен',
        ];
    }

    public function beforeValidate()
    {
        $cart = Yii::$app->cart;
        if (parent::beforeValidate()) {
            if (!$cart->getIsEmpty() && $value = base64_encode(Yii::$app->session[$cart->id])) {
                $this->value = $value;
                $this->total_cost = $cart->getCost(true);
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $cart = Yii::$app->cart;
        if (!$cart->getIsEmpty()) {
            $cart->deleteAll();
            Yii::$app->session->remove('discount');
        }

        if ($insert) {
            $this->trigger(Subscriber::EVENT_NEW_SUBSCRIBER);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city', 'address', 'phone', 'email', 'delivery_date', 'city'], 'required'],
            [['delivery_date'], 'safe'],
            [['coupon_id', 'status', 'total_cost', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['phone'], 'string', 'max' => 15], // if used inputMask max=15
            [['name'], 'trim'],
            [['surname', 'country', 'region', 'city', 'organization_name', 'post_index', 'email', 'name'], 'string', 'max' => 45],
            [['address', 'comment'], 'string', 'max' => 255],
            ['email', 'email'],
            [['value'], 'string'],
            ['country', 'default', 'value' => 'Украина'],
            ['status', 'default', 'value' => self::ORDER_NEW],
            ['delivery_date', 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>=', 'message' => "Дата доставки не может быть ранее ".date("Y-m-d")."."],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID заказа',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'country' => 'Страна',
            'region' => 'Область',
            'city' => 'Город',
            'address' => 'Адрес',
            'organization_name' => 'Название организации',
            'post_index' => 'Почтовый индекс',
            'phone' => 'Телефон (моб)',
            'delivery_date' => 'Дата доставки',
            'coupon_id' => 'Купон',
            'status' => 'Статус заказа',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'sort_by' => 'Sort By',
            'value' => 'Serialized cart data',
            'fullName' => 'ФИО покупателя',
            'fullAddress' => 'Адрес доставки',
            'total_cost' => 'Сумма заказа',
            'comment' => 'Комментарий'
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
        $scenarios['short'] = ['name', 'phone', 'status'];
        return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['id' => 'coupon_id']);
    }

    public function getFullName()
    {
        return $this->name.' '.$this->surname;
    }

    public function getFullAddress()
    {
        return ($this->organization_name ? $this->organization_name . ', ' : '') .
            $this->address . ', ' . $this->city . ', ' . ($this->region ? $this->region . ', ' : '') .
            $this->country . ' ' . $this->post_index;
    }

//    public function createSubscriber()
//    {
//        if (!$this->coupon_id) {
//            $subscriber = new Subscriber();
//            $subscriber->name = $this->name;
//            $subscriber->phone = $this->phone;
//            $subscriber->email = $this->email;
//
//            $subscriber->save();
//        }
//    }

    public function setOrderId()
    {
        $items = $this->getValue();
        foreach ($items as $key => $value) {
            $items[$this->id. '_' . $key] = $value;
            unset($items[$key]);
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return unserialize(base64_decode($this->value));
    }

    public function setValue($item_id, $item)
    {
        $value = $this->getValue();
        $new_id = $item->getId();
        if ($new_id != $item_id && array_key_exists($new_id, $value)) {
            return false;
        }
        $value[$item_id] = $item;
        $this->reCount($value);
        return $this->saveOrder($value);
    }

    public function deleteItem($item_id)
    {
        $value = $this->getValue();
        unset($value[$item_id]);
        $this->reCount($value);
        return $this->saveOrder($value);
    }

    public function reCount($value)
    {
        $new_cost = 0;
        foreach ($value as $item) {
            $new_cost += $item->getCost();
        }
        $this->total_cost = $this->coupon ? max(0, $new_cost - $this->coupon->campaign->discount) : $new_cost;
    }

    public function saveOrder($value)
    {
        $this->value = base64_encode(serialize($value));
        return $this->save(false);
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\OrderQuery(get_called_class());
    }
}

