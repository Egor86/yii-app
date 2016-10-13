<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 03.10.16
 * Time: 12:50
 */

namespace common\widgets;


use yii\base\InvalidConfigException;
use yii\base\Widget;

class SeoForm extends Widget
{
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException('Required `model` param isn\'t set.');
        }
    }

    public function run()
    {
        echo $this->render('seo_form', [
            'model' => $this->model->seoText
        ]);
    }

}