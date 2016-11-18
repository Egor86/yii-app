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
            [['imageFile', ], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => Yii::t('main', 'Картинка'),
        ];
    }

    public function uploadImage($class, $item_id, $path)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

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
            return false;
        } else {
            return false;
        }

    }
}