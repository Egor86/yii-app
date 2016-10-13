<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 03.10.16
 * Time: 22:31
 */

namespace common\behavior;


use common\models\ImageStorage;
use backend\models\MultipleImageForm;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class GalleryBehavior extends Behavior
{

    public $alias;

//    public $ignoredAttr = 'image_id';

    public $savePath = '';

//    public $private_image = ImageStorage::PUBLIC_IMAGE;

    private $imgForm;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'clearAll',
            ActiveRecord::EVENT_AFTER_INSERT => 'uploadImg',
            ActiveRecord::EVENT_AFTER_UPDATE => 'uploadImg',
        ];
    }

    public function init()
    {
        if (!isset($this->alias)) throw new InvalidConfigException('Alias can not be empty');

        parent::init();
    }


    public function getGallery()
    {
        $q = $this->owner->hasMany(ImageStorage::className(),
            ['item_id' => $this->owner->primaryKey()[0]])
            ->where(['class' => get_class($this->owner)]);

        $attr = $this->ignoredAttr;
        if ($attr && isset($this->owner->$attr)) $q = $q->andWhere(['<>', 'id', $this->owner->$attr]);

        return $q;
    }

    public function clearPhotoFromGallery($photo_id)
    {
        $photo = ImageStorage::findOne($photo_id);
        if ($photo) {
            if ($photo->class == get_class($this->owner) && $photo->item_id == $this->owner->primaryKey) {
                $photo->delete();
                return true;
            } else {
                return false;
            }
        } else return false;
    }

    public function getMultipleImageForm()
    {
        if (!isset($this->imgForm)) {
            $this->imgForm = new MultipleImageForm();
            return $this->imgForm;
        } else {
            return $this->imgForm;
        }

    }

    public function clearAll()
    {
        foreach ($this->owner->gallery as $photo)
            $photo->delete();
    }


    public function uploadImg()
    {
        $imgForm = $this->getMultipleImageForm();
//var_dump($this->owner->primaryKey); die();
        $imgForm->uploadImages(get_class($this->owner),
            $this->owner->primaryKey,
//            (int)$this->private_image,
//            $this->alias,
            $this->savePath . DIRECTORY_SEPARATOR . implode('', $this->owner->primaryKey));
    }


}