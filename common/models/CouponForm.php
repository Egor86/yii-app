<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 27.10.16
 * Time: 18:34
 */

namespace common\models;

use yii\base\Model;

class CouponForm extends Model
{
    public $coupon;
    public $email;
    public $phone;
    public $coupon_code;
    public $order_id;

    public function __construct(array $config = [], $coupon_id = false)
    {
        $coupon_id ? $this->coupon = Coupon::findOne($coupon_id) : false;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['coupon_code', 'email', 'phone',], 'required'],
            [['coupon_code', 'email'], 'string', 'max' => 45],
            ['phone', 'string', 'max' => 15],
            ['coupon_code', 'validateCouponCode'],
            ['order_id', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'coupon_code' => 'Код купона',
            'phone' => 'Телефон(моб)',
        ];
    }

    public function validateCouponCode($attribute, $params)
    {
        $this->coupon = Coupon::findOne(['coupon_code' => $this->{$attribute}]);

        if ($this->coupon && $subscriber = $this->coupon->subscriber) {
            if ($subscriber->email == $this->email && $subscriber->phone == $this->phone) {
                if ($this->coupon->using_status == Coupon::UNUSED && time() > $this->coupon->expiry_date) {
                    $this->coupon->using_status = Coupon::USED;
                    if (!$this->coupon->update(false)) {
                        $this->addError('phone', 'Отправьте купон еще раз');
                        return false;
                    }
                    return true;
                }
                $this->addError('coupon_code', 'Срок действия купон истек');
                return false;
            }
            $this->addError('coupon_code', 'Указанный купон принадлежит клиенту с другим номером телефона и/или email');
            return false;
        } else {
            $this->addError('coupon_code', 'Неверно указан код купона');
            return false;
        }
    }
}