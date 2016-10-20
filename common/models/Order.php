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
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property string $value
 * @property string $coupon_code
 * @property integer $total_cost
 *
 * @property OrderProduct[] $orderProducts
 */
class Order extends \yii\db\ActiveRecord
{
    const FAST_ORDER = 0;
    const NEW_ORDER = 1;
    const PROCESSED_ORDER = 2;
    const REVOKED_ORDER = 3;
    const DONE_ORDER = 4;

    public $verifyCode;
    public $coupon_code;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public static function getStatus(){
        return [
            self::FAST_ORDER => 'Быстрый заказ',
            self::NEW_ORDER => 'Новый',
            self::PROCESSED_ORDER => 'В процессе',
            self::REVOKED_ORDER => 'Отменен',
            self::DONE_ORDER => 'Завершен',
        ];
    }

    public function beforeValidate()
    {
        if ($this->coupon_code) {
            $coupon = Coupon::findOne(['coupon_code' => $this->coupon_code]);
            if ($coupon && $coupon->using_status == Coupon::UNUSED) {
                $subscriber = $coupon->subscriber;
                if ($subscriber->email == $this->email && $subscriber->phone = $this->phone) {
                    $this->coupon_id = $coupon->id;
                    return true;
                } else {
                    $this->addError('coupon_code', 'Указанный купон принадлежит другому пользователю');
                    return false;
                }

            } else {
                $this->addError('coupon_code', $coupon ? 'Указанный купон уже использован' : 'Неверно указан код купона');
                return false;
            }
        }
        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->coupon_id) {
            $coupon = Coupon::findOne($this->coupon_id);
            $coupon->using_status = Coupon::USED;
            $coupon->save();
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
            [['coupon_id', 'status_id', 'total_cost', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 64],
            [['surname', 'country', 'region', 'city', 'organization_name', 'post_index', 'coupon_code'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'country' => 'Страна',
            'region' => 'Область',
            'city' => 'Город',
            'address' => 'Адрес',
            'organization_name' => 'Название организации',
            'post_index' => 'Почтовый индекс',
            'phone' => 'Телефон(моб)',
            'email' => 'Email',
            'delivery_date' => 'Дата доставки',
            'coupon_id' => 'Купон',
            'status_id' => 'Статус заказа',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'sort_by' => 'Sort By',
            'value' => 'Serialized cart data',
            'fullName' => 'ФИО покупателя',
            'fullAddress' => 'Адрес доставки',
            'coupon_code' => 'Код купона',
            'total_cost' => 'Сумма заказа',
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
        $scenarios['fast'] = ['name', 'phone', 'verifyCode', 'status_id'];
        return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['id' => 'coupon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id'])->inverseOf('order');
    }

    public function getFullName()
    {
        return $this->name.' '.$this->surname;
    }

    public function getFullAddress()
    {
        return ($this->organization_name ? $this->organization_name . ', ' : '') .
            $this->address . ', ' . $this->city . ($this->region ? $this->region . ', ' : '') .
            $this->country . $this->post_index;
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

