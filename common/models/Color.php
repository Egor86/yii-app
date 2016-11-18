<?php

namespace common\models;

use common\models\active_query\ColorQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "color".
 *
 * @property integer $id
 * @property string $name
 * @property string $rgb_code
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort_by
 * @property integer $type
 *
 * @property ProductColor[] $productColors
 */
class Color extends \yii\db\ActiveRecord
{
    const COLOR_RGB = 0;
    const COLOR_COVER = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['rgb_code', 'required', 'when' => function($model) {
                return $model->type == Color::COLOR_RGB;
            }],
            [['created_at', 'updated_at', 'sort_by', 'type'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['rgb_code'], 'string', 'max' => 7],
            ['type', 'default', 'value' => self::COLOR_RGB],
            [['name'], 'unique'],
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
            'name' => 'Название цвета',
            'rgb_code' => 'Цвет',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'sort_by' => 'Sort By',
            'type' => 'Type',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['caver'] = ['name', 'type'];
        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(ProductColor::className(), ['color_id' => 'id']);
    }

    public static function getCount()
    {
        return self::find()->count();
    }

    /**
     * @inheritdoc
     * @return ColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColorQuery(get_called_class());
    }
}
