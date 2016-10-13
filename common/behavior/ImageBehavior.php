<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 22.09.16
 * Time: 9:33
 */

namespace common\behaviors;


use common\models\files\ImageStorage;
use common\models\forms\ImageForm;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class ImageBehavior extends Behavior
{
    public $alias;

    public $imageAttr = 'image_id';

    public $savePath = '';

    public $private_image = ImageStorage::PUBLIC_IMAGE;

    private $imgForm;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'clearImg',
            ActiveRecord::EVENT_AFTER_INSERT => 'uploadImg',
            ActiveRecord::EVENT_AFTER_UPDATE => 'uploadImg',
        ];
    }

    public function init()
    {
        if (!isset($this->alias)) throw new InvalidConfigException('Alias can not be empty');

        parent::init();
    }


    public function getImage()
    {
        return $this->owner->hasOne(ImageStorage::className(), ['id' => $this->imageAttr]);
    }

    public function getImageForm()
    {
        if (!isset($this->imgForm)) {
            $this->imgForm = new ImageForm();
            return $this->imgForm;
        } else {
            return $this->imgForm;
        }

    }

    public function clearImg()
    {
        $attr = $this->imageAttr;

        if ($this->owner->image)
            if ($this->owner->image->delete()) {
                $this->owner->$attr = null;
                return true;
            } else {
                return false;
            }
        else {
            return false;
        }
    }


    public function uploadImg()
    {
        $imgForm = $this->getImageForm();

        $img_id = $imgForm
            ->uploadImage(get_class($this->owner),
                $this->owner->primaryKey,
                (int) $this->private_image,
                $this->alias,
                $this->savePath . DIRECTORY_SEPARATOR . $this->owner->primaryKey);

        if (isset($img_id) && $img_id) {

            if ($this->owner->image) $this->clearImg();

            \Yii::$app->db->createCommand()
                ->update($this->owner->tableName(),
                    [$this->imageAttr => $img_id],
                    [$this->owner->primaryKey()[0] => $this->owner->primaryKey])
                ->execute();
        }
    }



}