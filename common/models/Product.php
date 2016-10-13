<?php

namespace common\models;

use common\behavior\SeoBehavior;
use common\models\active_query\ProductQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $brand_id
 * @property integer $video_id
 * @property integer $category_id
 * @property string $stock_keeping_unit
 * @property string $slug
 * @property string $price
 * @property string $discount_price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $amount
 * @property string $published
 * @property integer $sort_by
 *
 * @property Brand $brand
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    const PUBLISHED = 1;
    const UNPUBLISHED = 0;

    public static function publishedList(){
        return [
            self::PUBLISHED => 'Да',
            self::UNPUBLISHED => 'Нет'
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
        if (parent::beforeDelete()) {
            ProductColor::deleteAll(['product_id' => $this->id]);
            VideoStorage::deleteAll(['id' => $this->video_id]);
            ImageStorage::deleteAll(['class_item_id' => $this->id, 'class' => __CLASS__]);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'brand_id', 'category_id', 'stock_keeping_unit', 'slug', 'price'], 'required'],
            [['description', 'published'], 'string'],
            [['brand_id', 'video_id', 'category_id', 'created_at', 'updated_at', 'sort_by', 'amount'], 'integer'],
            [['price', 'discount_price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['stock_keeping_unit'], 'string', 'max' => 10],
            [['slug'], 'string', 'max' => 150],
            [['slug'], 'unique'],
            [['stock_keeping_unit'], 'unique'],
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
            'name' => 'Наименование товара',
            'description' => 'Описание',
            'brand_id' => 'Бренд',
            'videoStorage' => 'Видео',
            'category_id' => 'Категория',
            'stock_keeping_unit' => 'Артикул',
            'slug' => 'URL',
            'price' => 'Цена',
            'discount_price' => 'Цена со скидкой',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'published' => 'Опубликован',
            'sort_by' => 'Sort By',
            'status' => 'Наличие',
            'brand.name' => 'Бренд',
            'category.name' => 'Категория',
            'amount' => 'В наличии',
            'seo.title' => 'SEO title',
            'seo.description' => 'SEO текст',
            'seo.keyword' => 'SEO ключевые слова',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getVideo()
    {
        return $this->hasOne(VideoStorage::className(), ['id' => 'video_id']);
    }

    public function getColors()
    {
        return $this->hasMany(ProductColor::className(), ['product_id' => 'id']);
    }

    public function getSizes(){
        return $this->hasMany(ProductColorSize::className(), ['product_color_id' => 'product_id'])
            ->viaTable('product_color', ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

//    public function getStatus() // TODO after create update producr_color_size change amount
//    {
//        $prod_color = Product::findOne($this->id)->productColors;
//
//        for ($i = 0; $i < count($prod_color); $i++){
//            $product_color_size = ProductColor::findOne($prod_color[$i]->id)->productColorSizes;
//
//            for ($j = 0; $j < count($product_color_size); $j++){
//
//                if ($product_color_size[$j]->amount > 0){
//                    return 'Есть';
//                }
//            }
//        }
//        return 'Нет';
//    }
}