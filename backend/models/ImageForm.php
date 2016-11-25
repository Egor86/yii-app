<?php
/**
 * Created by PhpStorm.
 * User: ?\_(?)_/?
 * Date: 18.07.2016
 * Time: 13:02
 */

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\Image;
use Yii;
use common\models\ImageStorage;
use common\helpers\Upload;


class ImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;


    public function rules()
    {
        return [
            [['imageFile', ], 'file', 'extensions' => 'png, jpg'],
            ['imageFile',  'file','skipOnEmpty' => true, 'when' => function($model) {
                return UploadedFile::getInstance($this, 'imageFile');
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => 'Изображение',
        ];
    }

    public function uploadImage($class, $item_id, $path)
    {
        if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {

            $cover_loaded = ImageStorage::findOne(['class' => $class, 'class_item_id' => $item_id]);
            if (!empty($cover_loaded)) {
                $this->addError('imageFile', 'Для загрузки нового изображения, необходимо удалить старое');
                return false;
            }

            if ($this->validate()) {
                if (($url = Image::upload($this->imageFile, Yii::getAlias('@front-web'), $path))) {
                    $image = new ImageStorage([
                        'class' => $class,
                        'class_item_id' => $item_id,
                        'file_path' => $url,
                        'name' => Upload::getFileName($this->imageFile)
                    ]);
                    if ($image->save()) {
                        $this->imageFile = null;
                        return $image->id;
                    }
                }
            }
            return false;
        }
        return true;
    }
}