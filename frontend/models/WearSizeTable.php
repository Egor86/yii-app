<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "wear_size_table".
 *
 * @property integer $id
 * @property string $size
 * @property string $34/XS/42
 * @property string $36/S/44
 * @property string $38/M/46
 * @property string $40/L/48
 * @property string $42/XL/50
 * @property string $44/XXL/52
 * @property string $46/XXXL/54
 */
class WearSizeTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wear_size_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size', '34/XS/42', '36/S/44', '38/M/46', '40/L/48', '42/XL/50', '44/XXL/52', '46/XXXL/54'], 'required'],
            [['size'], 'string', 'max' => 45],
            [['34/XS/42', '36/S/44', '38/M/46', '40/L/48', '42/XL/50', '44/XXL/52', '46/XXXL/54'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Size',
            '34/XS/42' => '34/ Xs/42',
            '36/S/44' => '36/ S/44',
            '38/M/46' => '38/ M/46',
            '40/L/48' => '40/ L/48',
            '42/XL/50' => '42/ Xl/50',
            '44/XXL/52' => '44/ Xxl/52',
            '46/XXXL/54' => '46/ Xxxl/54',
        ];
    }
}
