<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "shoes_size_table".
 *
 * @property integer $id
 * @property string $size_ru
 * @property string $size_uk
 * @property string $size_eu
 * @property string $size_us
 */
class ShoesSizeTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shoes_size_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size_ru', 'size_uk', 'size_eu', 'size_us'], 'required'],
            [['size_ru', 'size_uk', 'size_eu', 'size_us'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size_ru' => 'Size Ru',
            'size_uk' => 'Size Uk',
            'size_eu' => 'Size Eu',
            'size_us' => 'Size Us',
        ];
    }
}
