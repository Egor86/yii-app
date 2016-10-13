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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city', 'address', 'phone', 'email', 'delivery_date'], 'required'],
            [['delivery_date'], 'safe'],
            [['coupon_id', 'status_id', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 64],
            [['surname', 'country', 'region', 'city', 'organization_name', 'post_index'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            ['verifyCode', 'captcha'],
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

    /**
     * @inheritdoc
     * @return \common\models\active_query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\OrderQuery(get_called_class());
    }
}

