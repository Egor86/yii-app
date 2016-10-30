<?php

/** @var $coupon common\models\Coupon*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

//$this->registerJs(
//    '$("document").ready(function(){
//            $("#new_note").on("pjax:end", function() {
//            console.log(12213);
//            $.pjax.reload({container:"#coupon"});
//        });
//    });'
//);
?>
<div class="coupon-form">
    <?php Pjax::begin(['id' => 'coupon' , 'enablePushState' => false]); ?>

    <?php $form = ActiveForm::begin(['action' => '/coupon/verify'.Yii::$app->urlManager->suffix, 'options' => ['data-pjax' => true ]]); ?>

        <?= $form->field($coupon_form, 'coupon_code') ?>

        <?= $form->field($coupon_form, 'email')->textInput(['maxlength' => true])->widget(MaskedInput::className(),[
        'name' => 'email',
        'clientOptions' => ['alias' =>  'email']
        ]) ?>

        <?= $form->field($coupon_form, 'phone')->textInput(['maxlength' => true])->widget(MaskedInput::className(),[
            'name' => 'phone',
            'mask' => '(999) 999-99-99',
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
            ]
        ]) ?>

    <div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>