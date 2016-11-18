<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $brand_id
 * @property integer $video_id
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $published
 * @property integer $sort_by
 *
 * @property Comment[] $comments
 * @property Brand $brand
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    const PUBLISHED = 1;
    const UNPUBLISHED = 0;

    public static function publishedList(){
        return [
            self::UNPUBLISHED => 'Нет',
            self::PUBLISHED => 'Да'
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public function beforeDelete()
    {
        if (Item::find()->where(['product_id' => $this->id])->one()) {
            return false;
        }

        $this->video_id ? VideoStorage::findOne($this->video_id)->delete() : null;
        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'brand_id', 'category_id'], 'required'],
            [['description'], 'string'],
            [['brand_id', 'video_id', 'category_id', 'created_at', 'updated_at', 'sort_by', 'published'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['published', 'in', 'range' => array_keys(self::publishedList())],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'name' => 'Наименование продукта',
            'description' => 'Описание',
            'brand_id' => 'Бренд',
            'video_id' => 'Видео',
            'category_id' => 'Категория',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'published' => 'Опубликован?',
            'sort_by' => 'Sort By',
            'videoStorage' => 'Видео',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id'])->inverseOf('products');
    }


    public function getVideo()
    {
        return $this->hasOne(VideoStorage::className(), ['id' => 'video_id']);
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->inverseOf('products');
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ProductQuery(get_called_class());
    }
}
