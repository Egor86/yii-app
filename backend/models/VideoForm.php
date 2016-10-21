<?php

namespace backend\models;

use common\models\VideoStorage;
use yii\base\Model;
use yii\web\UploadedFile;
use common\helpers\Image;
use Yii;
use common\helpers\Upload;


class VideoForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $videoFile;


    public function rules()
    {
        return [
            [['videoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4, mpeg, mpg, avi, mp2',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'videoFile' => 'Video',
        ];
    }

    public function uploadVideo($class, $item_id, $path = 'video_storage')
    {
        $this->videoFile = UploadedFile::getInstance($this, 'videoFile');
        if ($this->validate() || $this->videoFile) {

            if (($url = Image::upload($this->videoFile, Yii::getAlias('@front-web'), $path))) {
                $video = new VideoStorage([
                    'class' => $class,
                    'item_id' => $item_id,
                    'url' => $url,
                    'file_name' => Upload::getFileName($this->videoFile)
                ]);
                if ($video->save()) {
                    $this->videoFile = null;
                    return $video->id;
                }
            }
        }
        $this->addError('videoFile', 'Видео не сохранилось');
        return false;


    }
}