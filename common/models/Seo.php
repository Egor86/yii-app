<?php

namespace common\models;

use common\models\active_query\SeoQuery;
use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property integer $id
 * @property string $class_name
 * @property string $title
 * @property string $description
 * @property string $keyword
 * @property integer $class_item_id
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_name', 'class_item_id'], 'required'],
            [['class_item_id'], 'integer'],
            [['class_name', 'title', 'description', 'keyword'], 'string', 'max' => 255],
            [['class_name', 'class_item_id'], 'unique', 'targetAttribute' => ['class_name', 'class_item_id'], 'message' => 'The combination of Class Name and Class Item ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'title' => 'SEO Title',
            'description' => 'SEO Description',
            'keyword' => 'SEO Keyword',
            'class_item_id' => 'Class Item ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeoQuery(get_called_class());
    }

    public function isEmpty()
    {
        return (!$this->title && !$this->keyword && !$this->description);
    }
}
