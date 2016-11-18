<?php

namespace common\models;

use common\behavior\SeoBehavior;
use common\models\active_query\CategoryQuery;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent
 * @property string $slug
 * @property integer $size_table_name_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 *
 * @property SizeTableName $sizeTableName
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    public function beforeDelete() {
        if (self::find()->where(['parent' => $this->id])->one() ||
            Product::find()->where(['category_id' => $this->id])->one()) {
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'size_table_name_id'], 'required'],
            [['description'], 'string'],
            [['parent', 'size_table_name_id', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            ['parent', 'default', 'value' => 0],
            [['slug'], 'string', 'max' => 30],
            ['slug', 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => 'URL может состоять из латиницы и тире'],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['size_table_name_id'], 'exist', 'skipOnError' => true, 'targetClass' => SizeTableName::className(), 'targetAttribute' => ['size_table_name_id' => 'id']],
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
            'name' => 'Название категории',
            'description' => 'Описание',
            'parent' => 'Родительская категория',
            'slug' => 'URL',
            'size_table_name_id' => 'Название таблицы размеров',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'sort_by' => 'Sort By',
            'seo.title' => 'SEO title',
            'seo.description' => 'SEO текст',
            'seo.keyword' => 'SEO ключевые слова',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizeTableName()
    {
        return $this->hasOne(SizeTableName::className(), ['id' => 'size_table_name_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function getParentsList(){

        $parents = Category::find()
            ->select(['id', 'name'])
            ->where(['in', 'id',
                (new Query())
                    ->select('parent')
                    ->from('category')
                    ->distinct()])
            ->asArray()->all();

        $parents[] = [
            'id' => 0,
            'name' => 'Родитель'
        ];

        return ArrayHelper::map($parents, 'id', 'name');
    }
}
