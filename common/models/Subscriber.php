<?php

namespace common\models;

use common\models\active_query\SubscriberQuery;
use Mailchimp;
use Yii;
use yii\base\Event;
use yii\db\Exception;

/**
 * This is the model class for table "subscriber".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $euid
 * @property string $leid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property integer $mail_chimp_status
 * @property string $group
 */
class Subscriber extends \yii\db\ActiveRecord
{
    const LIST_NAME        = 'List2_customer';
    const GROUPINGS_ID     = 741;
    const GROUP_ORDER      = 1;
    const GROUP_PRE_ORDER  = 2;
    const GROUP_COUPON     = 3;
    const PENDING          = 0;
    const SUBSCRIBED       = 1;
    const UNSUBSCRIBED     = 2;
    const CLEANED          = 3;

    const EVENT_NEW_SUBSCRIBER = 'createNewSubscriber';

    public function init()
    {
        parent::init();
        $this->on(Coupon::EVENT_GET_COUPON, [new Coupon(), 'createCoupon']);
    }
    /**
     * @inheritdoc
     */

    public static function getGroup()
    {
        return [
            self::GROUP_PRE_ORDER   => 'pre-order',
            self::GROUP_ORDER       => 'order',
            self::GROUP_COUPON      => 'coupon'
        ];
    }
//    public static function getMailChimpStatus()
//    {
//        return [
//            self::PENDING       => 'В ожидании',
//            self::SUBSCRIBED    => 'Подписан',
//            self::UNSUBSCRIBED  => 'Отписался',
//            self::CLEANED       => 'Недоставленные'
//        ];
//    }
    public static function getMailChimpStatus(){
        return [
            'pending' => 'В ожидании',
            'subscribed' => 'Подписан',
            'unsubscribed'  => 'Отписался',
            'cleaned' => 'Недоставленные'
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
                $merge_vars['groupings'] = [['id' => self::GROUPINGS_ID, 'groups' => [self::getGroup()[$this->group]]]];
                $merge_vars['FNAME'] = $this->name;
                $email['email'] = $this->email;
                $mailchimp = new Mailchimp(Yii::$app->params['mailchimpAPIkey']);
                $list_id = $mailchimp->lists->getList(['list_name' => self::LIST_NAME]);    // set the desired list_name

                $result = $mailchimp->lists->subscribe(
                    $list_id['data'][0]['id'],
                    $email,
                    $merge_vars
                );
                if (empty($result)) {
                    return false;
                }

                $this->euid = $result['euid'];
                $this->leid = $result['leid'];
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
            [['created_at', 'updated_at', 'sort_by', 'group'], 'integer'],
            [['email', 'phone'], 'unique', 'targetAttribute' => ['email', 'phone']],
            ['email', 'email', 'message' => 'Некорректный email'],
            ['email', 'unique', 'message' => 'Указанный email уже зарегистрирован'],
//            ['phone', 'unique'],
            [['name', 'email', 'leid', 'euid', 'mail_chimp_status'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
            ['mail_chimp_status', 'default', 'value' => 'pending'],
            ['group', 'default', 'value' => self::GROUP_COUPON],
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
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Номер мобильного',
            'euid' => 'Mail Chimp Euid',
            'leid' => 'Mail Chimp Leid',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'sort_by' => 'Sort By',
            'coupon' => 'Купон',
            'couponUsingStatus' => 'Использован',
            'mail_chimp_status' => 'Статус подписки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::className(), ['subscriber_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreOrders()
    {
        return $this->hasMany(PreOrder::className(), ['subscriber_id' => 'id']);
    }

    /**
     * @param $event Event
     * $event->data - const subscriber group index
     * @return bool
     */
    public function createSubscriber($event)
    {
        if (!self::find()
            ->where(['email' => $event->sender->email, 'phone' => $event->sender->phone])
            ->one()
        ) {
            $subscriber = new self();
            $subscriber->load(Yii::$app->request->post(), $event->sender->formName());
            $subscriber->group = $event->data;
            if ($subscriber->validate()) {
                $subscriber->save(false);
            }
        }
        return true;
    }

    public static function updateMailChimp()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $email_list = array_chunk(Subscriber::find()->select('leid')->asArray()->all(), 5);

            $mailChimp = new Mailchimp(Yii::$app->params['mailchimpAPIkey']);
            $list_id = $mailChimp->lists->getList(['list_name' => self::LIST_NAME]);

            for ($i = 0; $i < count($email_list); $i++) {
                $memberInfo = $mailChimp->lists->memberInfo($list_id['data'][0]['id'], $email_list[$i])['data'];
                for ($j = 0; $j < count($memberInfo); $j++){
                    $subscriber = Subscriber::findOne(['leid' => $memberInfo[$j]['leid']]);
                    if ($subscriber && $subscriber->mail_chimp_status != $memberInfo[$j]['status']){
                        $subscriber->mail_chimp_status = $memberInfo[$j]['status'];
                        $subscriber->save();
                    }
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
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
