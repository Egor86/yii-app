<?php

namespace common\models;

use common\behavior\SeoBehavior;
use common\models\active_query\PageQuery;
use Yii;
use yii\base\Event;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $slug
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 */
class Page extends \yii\db\ActiveRecord
{
    const PUBLISHED = 1;
    const UNPUBLISHED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'slug'], 'required'],
            [['text', 'status'], 'string'],
            [['created_at', 'updated_at', 'sort_by'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 45],
            [['slug'], 'unique'],
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
            'seoBehavior' => SeoBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'text' => 'Текст',
            'slug' => 'URL',
            'status' => 'Опубликована',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
            'sort_by' => 'Sort By',
            'seo.title' => 'SEO title',
            'seo.description' => 'SEO текст',
            'seo.keyword' => 'SEO ключевые слова',
        ];
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    public static function statusList(){
        return [
            self::PUBLISHED => 'Да',
            self::UNPUBLISHED => 'Нет'
        ];
    }
}
