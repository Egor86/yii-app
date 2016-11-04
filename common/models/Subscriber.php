<?php

namespace common\models;

use common\models\active_query\SubscriberQuery;
use Mailchimp;
use Yii;

/**
 * This is the model class for table "subscriber".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $mail_chimp_euid
 * @property string $mail_chimp_leid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property string $mail_chimp_status
 * @property string $group
 */
class Subscriber extends \yii\db\ActiveRecord
{
    const GROUPINGS_ID     = 741;
    const GROUP_CUSTOMER   = 'customer';
    const GROUP_SUBSCRIBER = 'subscriber';
    const GROUP_COUPON     = 'coupon';
    const LIST_NAME        = 'List2_customer';

    public function init()
    {
        parent::init();
        $this->on(Coupon::EVENT_GET_COUPON, [new Coupon(), 'createCoupon']);
    }
    /**
     * @inheritdoc
     */

    public static function getMailChimpStatus(){

        return [
            'pending'       => 'В ожидании',
            'subscribed'    => 'Подписан',
            'unsubscribed'  => 'Отписальса',
            'cleaned'       => 'Недоставленные'
        ];
    }

    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * Created for changing coupon parameters in admin panel. Not used.
     * @param bool $insert
     * @return bool
     */
//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)){
//
//            if (isset($this->coupon['id'])){
//                $coupon = Coupon::findOne($this->coupon['id']);
//                $coupon->coupon_code = $this->coupon['coupon_code'];
//                $coupon->using_status = $this->coupon['using_status'];
//
//                if (!$coupon->save()){
//                    return false;
//                }
//                return true;
//            }
//            if (!empty($this->coupon)){
//                $coupon = new Coupon();
//                $coupon->subscriber_id = $this->id;
//                $coupon->coupon_code = $this->coupon['coupon_code'];
//                $coupon->using_status = $this->coupon['using_status'];
//                    if(!$coupon->save()){
//                        return false;
//                    }
//                return true;
//            }
//            return true;
//        }
//        return false;
//    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $merge_vars['groupings'] = [['id' => self::GROUPINGS_ID, 'groups' => [$this->group]]];
                $email['email'] = $this->email;
                $mailchimp = new Mailchimp(Yii::$app->params['mailchimpAPIkey']);
                $list_id = $mailchimp->lists->getList(['list_name' => self::LIST_NAME]);    // set the desired list_name

                $result = $mailchimp->lists->subscribe(
                    $list_id['data'][0]['id'],
                    $email,
                    $merge_vars
                );

                $this->mail_chimp_euid = $result['euid'];
                $this->mail_chimp_leid = $result['leid'];
            }
            return true;
        }
        return false;
    }

//
//    public function beforeDelete()
//    {
//        if (parent::beforeDelete()) {
//
//            Coupon::findOne(['subscriber_id' => $this->id])->delete();
//
//            return true;
//        } else {
//            return false;
//        }
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone'], 'required'],
            [['created_at', 'updated_at', 'sort_by'], 'integer'],
            ['email', 'unique'],
            ['phone', 'unique'],
            [['name', 'email', 'mail_chimp_leid', 'group', 'mail_chimp_euid'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
            [['mail_chimp_status'], 'string', 'max' => 15, ],
            ['mail_chimp_status', 'default', 'value' => 'pending'],
            ['group', 'default', 'value' => self::GROUP_SUBSCRIBER],
            [['coupon'], 'safe']
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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'mail_chimp_euid' => 'Mail Chimp Euid',
            'mail_chimp_leid' => 'Mail Chimp Leid',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'sort_by' => 'Sort By',
            'coupon' => 'Купон',
            'couponUsingStatus' => 'Использован',
            'mail_chimp_status' => 'Статус подписки', // TODO request to the mailchimp by Lists::memberInfo
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['subscriber_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreOrders()
    {
        return $this->hasMany(PreOrder::className(), ['subscriber_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SubscriberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscriberQuery(get_called_class());
    }
}
