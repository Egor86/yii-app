<?php

namespace common\models;

use common\helpers\Image;
use common\helpers\Upload;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

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

    public $image;
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'image_storage';
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_MAIN => 'Основное изображение',
            self::TYPE_SECOND_MAIN => 'Второе основое изображение',
            self::TYPE_OTHER => 'Остальные изображения',
        ];
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

    public function uploadImages($class, $item_id, $path = '')
    {
        $this->image = UploadedFile::getInstances($this, 'image');
        $this->class =$class;
        $this->class_item_id = $item_id;

        if (($this->image && $this->saveImages($class, $item_id, $path))) {
            $this->image = null;
            return true;
        }
        return false;
    }

    private function saveImages($class, $item_id, $path)
    {
        if ($this->type == self::TYPE_MAIN || $this->type == self::TYPE_SECOND_MAIN){
            if (self::findOne(['class' => $class, 'class_item_id' => $item_id, 'type' => $this->type])){
                $this->addError('image', self::getTypeList()[$this->type] . ' для товара этого цвета уже существует');
                return false;
            }
        }

        if (($this->file_path = Image::upload($this->image, Yii::getAlias('@front-web'), $path))) {
            $this->name = Upload::getFileName($this->image);
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }
}
