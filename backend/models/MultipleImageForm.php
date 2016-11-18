<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 03.10.16
 * Time: 22:18
 */

namespace backend\models;


use yii\base\Event;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\Image;
use Yii;
use common\models\ImageStorage;
use common\helpers\Upload;


class MultipleImageForm extends Model
{

    /**
     * @var UploadedFile[]
     */
    public $type;
    public $img;
    public $imageMain;
    public $imageSecondMain;
    public $imageOther;


    public function rules()
    {
        return [
            [['imageMain', ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageSecondMain', ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageOther', ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageMain' => Yii::t('app','Основное фото'),
            'imageSecondMain' => Yii::t('app','Второе основное фото'),
            'imageOther' => Yii::t('app','Остальные фото'),
        ];
    }

    public function uploadImages($class, $item_id, $path = '')
    {
        $this->imageMain = UploadedFile::getInstances($this, 'imageMain');
        $this->imageSecondMain = UploadedFile::getInstances($this, 'imageSecondMain');
        $this->imageOther = UploadedFile::getInstances($this, 'imageOther');

        if (
            ($this->imageMain && $this->saveImages($this->imageMain, $class, $item_id, $path, ImageStorage::TYPE_MAIN)) ||
            ($this->imageSecondMain && $this->saveImages($this->imageSecondMain, $class, $item_id, $path, ImageStorage::TYPE_SECOND_MAIN)) ||
            ($this->imageOther && $this->saveImages($this->imageOther, $class, $item_id, $path, ImageStorage::TYPE_OTHER))
        ) {
            $this->imageMain = null;
            $this->imageSecondMain = null;
            $this->imageOther = null;
            return true;
        }


//        if ($this->imageOther && $this->saveImages($this->imageOther, $class, $item_id, $path)){
//            $this->imageOther = null;
//            return true;
//        }

        return false;
    }

    private function saveImages($images, $class, $item_id, $path, $type)
    {
        if ($type == ImageStorage::TYPE_MAIN || $type == ImageStorage::TYPE_SECOND_MAIN){
            if (ImageStorage::findOne(['class' => $class, 'class_item_id' => $item_id, 'type' => $type])){
                    throw new Exception('Перезагризите страницу и удалите текущее фото, после чего сохраните новое.');
            }
        }

        foreach ($images as $key => $file) {
            if (($url = Image::upload($file, Yii::getAlias('@front-web'), $path))) {
                $photo = new ImageStorage([
                    'name' => Upload::getFileName($file),
                    'class' => $class,
                    'class_item_id' => $item_id,
                    'file_path' => $url,
                    'type' => $type
                ]);
                $photo->save();
            }
        }
        return true;
    }
}