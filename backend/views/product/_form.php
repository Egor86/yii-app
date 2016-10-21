<?php

use common\models\Brand;
use common\models\Category;
use kartik\file\FileInput;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $video_form backend\models\VideoForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'brand_id')
        ->dropDownList(ArrayHelper::map(Brand::find()
            ->all(), 'id', 'name'),$model->brand_id ? [
            'options' => [$model->brand_id => ['selected' => 'selected']]] : ['prompt' => '--']) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()
        ->all(), 'id', 'name'),$model->category_id ? [
        'options' => [$model->category_id => ['selected' => 'selected']]] : ['prompt' => '--']) ?>

    <?php if(!$model->video || !$model->video->url) : ?>
    <?= $form->field($video_form, 'videoFile')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'video/*',
        ],
        'pluginOptions' => [
            'maxFileCount' => 1,
            'showRemove' => true,
            'showUpload' => false,
            'showCaption' => false,
            'overwriteInitial' => false,
        ],
    ]) ?>
    <?php  else : ?>
        <?= "<iframe width='480' height='270' src='".$model->video->url."' frameborder='0'></iframe>";?>
        <?= Html::a('Удалить видео', ['/product/delete-video?id='.$model->id], ['class'=>'product-form btn btn-primary']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'published')->widget(SwitchInput::classname(), ['pluginOptions' => [
        'onText' => 'Да',
        'offText' => 'Нет',
    ]]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
