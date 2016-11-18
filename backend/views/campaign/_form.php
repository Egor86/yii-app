<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $form yii\widgets\ActiveForm */

$data1 = new DateTime(date("Y-m-d H:i", $model->coupon_action_time));
$data2 = new DateTime(date("Y-m-d H:i", 0));
$interval = $data1->diff($data2);
?>

<div class="campaign-form">
    <?php $form = ActiveForm::begin([ 'action' => $model->isNewRecord ? 'campaign/create' : 'update?id=' . $model->id, ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled' => $model->name ? true : false, 'style' => 'width: 350px'])?>

    <?= $form->field($model, 'discount')->input('number',['disabled' => $model->discount ? true : false, 'style' => 'width: 150px']); ?>

    <?= $form->field($model, 'coupon_action_time[day]')->input('number', [
        'style' => 'width: 80px', 'value' => $model->coupon_action_time ? $interval->format('%d') : '00',  'min' => 0, 'disabled' => $model->coupon_action_time ? true : false
    ])->hint('дней') ?>

    <?= $form->field($model, 'coupon_action_time[hour]')->input('number', [
       'style' => 'width: 80px', 'value' => $model->coupon_action_time ? $interval->format('%h') : '00', 'min' => 0, 'max' => 23,  'disabled' => $model->coupon_action_time ? true : false
    ])->label(false)->hint('часов') ?>

    <?= $form->field($model, 'coupon_action_time[minute]')->input('number', [
        'style' => 'width: 80px', 'value' => $model->coupon_action_time ? $interval->format('%i') : '00', 'min' => 0, 'max' => 59, 'disabled' => $model->coupon_action_time ? true : false
        ])->label(false)->hint('минут') ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::className(),['pluginOptions' => [
        'onText' => 'Активная',
        'offText' => 'Закрыта',
    ]]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
