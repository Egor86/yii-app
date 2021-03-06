<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $text
 * @property integer $agree
 * @property integer $favorite
 * @property string $user_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $email
 * @property Item $item
 */
class Comment extends \yii\db\ActiveRecord
{
    const YES = 1;
    const NO = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'text', 'user_name', 'email'], 'required'],
            [['item_id', 'agree', 'favorite', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['text'], 'string', 'max' => 1000],
            [['user_name'], 'string', 'max' => 30],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['email'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Наименование товара',
            'text' => 'Текст комментария',
            'agree' => 'Одобрен',
            'favorite' => 'На главной',
            'user_name' => 'Имя пользователя',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'email' => 'Email',
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

//    public function scenarios()
//    {
//        $scenarios = parent::scenarios();
//        $scenarios['add'] = ['user_name', 'text', 'item_id'];
//        return $scenarios;
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\CommentQuery(get_called_class());
    }
}
