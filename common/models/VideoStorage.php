<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video_storage".
 *
 * @property integer $id
 * @property string $'file_name'
 * @property string $class
 * @property integer $item_id
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class VideoStorage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name', 'class', 'item_id', 'url'], 'required'],
            [['item_id', 'created_at', 'updated_at'], 'integer'],
            [['file_name', 'class'], 'string', 'max' => 45],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'file Name',
            'class' => 'Class',
            'item_id' => 'Item ID',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    public function afterDelete()
    {
        if ($this->url && (is_file($filePath = Yii::getAlias('@front-web') . $this->url))) {
            @unlink($filePath);
        }
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\VideoStorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\VideoStorageQuery(get_called_class());
    }
}
