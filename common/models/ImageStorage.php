<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "uploaded_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property integer $class_item_id
 * @property string $file_path
 * @property integer $size
 * @property string $type
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductFile[] $productFiles
 */
class ImageStorage extends \yii\db\ActiveRecord
{
    const TYPE_MAIN = 0;
    const TYPE_SECOND_MAIN  = 1;
    const TYPE_OTHER = 2;

    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'image_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class', 'class_item_id', 'file_path'], 'required'],
            [['class_item_id', 'created_at', 'updated_at', 'type'], 'integer'],
            [['name', 'class'], 'string', 'max' => 64],
            [['file_path'], 'string', 'max' => 256],
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
            'name' => 'Name',
            'class' => 'Class',
            'class_item_id' => 'Class Item ID',
            'file_path' => 'File Path',
            'size' => 'Size',
            'type' => '0 - first main photo, 1 - second main photo, 2 - other photo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterDelete()
    {
        if ($this->file_path && (is_file($filePath = Yii::getAlias('@front-web') . $this->file_path))) {
            @unlink($filePath);
        }
        parent::afterDelete();
    }

    /**
     * @param $model object
     * @param $type mixed
     * @return array
     */
    public static function getInitialPreview($model, $type)
    {
        $data = [];
        foreach (self::findAll(['class' => get_class($model), 'class_item_id' => $model->id, 'type' => $type]) as $file) {
            $data[] = Html::img($file->file_path, ['class' => 'file-preview-image']);
        }
        return $data;
    }

    /**
     * @param $model object
     * @param $type mixed
     * @return array
     */
    public static function getInitialPreviewConfig($model, $type)
    {
        $data = [];
        foreach (self::findAll(['class' => get_class($model), 'class_item_id' => $model->id, 'type' => $type]) as $file) {
            $data[] = [
                'key' => $file->id,
                'url' => Url::to(['/image/delete', 'id' => $file->id]),
            ];
        }
        return $data;
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ImageStorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ImageStorageQuery(get_called_class());
    }
}
