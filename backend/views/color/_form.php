<?php

use common\models\Color;
use common\models\ImageStorage;
use kartik\color\ColorInput;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Color */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="color-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->hiddenInput(['value' => !$model->isNewRecord ? $model->type : isset($imageForm) ? Color::COLOR_COVER : Color::COLOR_RGB])->label(false) ?>

    <?php   if (!empty($imageForm)) {
                echo $form->field($imageForm, 'imageFile')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                        'uploadAsync' => false,
                    ],
                    'pluginOptions' => [
                        'maxFileCount' => 1,
                        'showRemove' => true,
                        'showUpload' => false,
                        'showCaption' => false,
                        'overwriteInitial' => false,
                        'initialPreview' => ImageStorage::getInitialPreview($model),
                        'initialPreviewConfig' => ImageStorage::getInitialPreviewConfig($model),
        //                    'otherActionButtons' => '<button onclick="setItemImagePreview(this)" type="button" class="btn btn-default btn-xs js-set-item-image-preview" {dataKey}><span class="glyphicon glyphicon-star"></span></button>'
                    ],
                ]);
            } else {
                echo $form->field($model, 'rgb_code')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Select color ...'],
                ]);
            } ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
