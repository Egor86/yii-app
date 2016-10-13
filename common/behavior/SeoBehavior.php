<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 03.10.16
 * Time: 12:27
 */

namespace common\behavior;


use common\models\Seo;
use Yii;
use yii\db\ActiveRecord;

class SeoBehavior extends \yii\base\Behavior
{
    private $_model;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterInsert()
    {
        if($this->seoText->load(Yii::$app->request->post())){

            if(!$this->seoText->isEmpty()){
//                echo '<pre>';
//                @print_r($this->owner->primaryKey()[0]);
//                echo '</pre>';
//                exit(__FILE__ .': '. __LINE__);
                $this->seoText->save();
            }
        }
    }

    public function afterUpdate()
    {
        if($this->seoText->load(Yii::$app->request->post())){
            if(!$this->seoText->isEmpty()){
                $this->seoText->save();
            } else {
                if($this->seoText->primaryKey){
                    $this->seoText->delete();
                }
            }
        }
    }

    public function afterDelete()
    {
        if(!$this->seoText->isNewRecord){
            $this->seoText->delete();
        }
    }

    public function getSeo()
    {
        return $this->owner->hasOne(Seo::className(), ['class_item_id' => $this->owner->primaryKey()[0]])->where(['class_name' => get_class($this->owner)]);
    }

    public function getSeoText()
    {
        if(!$this->_model)
        {
            $this->_model = $this->owner->seo;
            if(!$this->_model){
                $this->_model = new Seo([
                    'class_name' => get_class($this->owner),
                    'class_item_id' => $this->owner->primaryKey
                ]);
            }
        }

        return $this->_model;
    }
}