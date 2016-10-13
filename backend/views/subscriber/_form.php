<?php

use common\models\Subscriber;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Subscriber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscriber-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php // disabled to update coupon data
     if(0 == 1) { ?>

        <?= $form->field($model, 'coupon[coupon_code]')
            ->textInput(['value' => ($coupon = \common\models\Coupon::findOne(['subscriber_id' => $model->id]))
                ? $coupon->coupon_code : '']) ?>

        <?= $coupon ? $form->field($model, 'coupon[id]')->textInput(['value' => $coupon->id, 'type' => 'hidden'])->label(false) : '' ?>

        <?= $form->field($model, 'coupon[using_status]')
            ->dropDownList(['Нет', 'Да'],
                $coupon ? [
                    'options' => [$coupon->using_status => ['selected' => 'selected']]] : ['prompt' => '--'])->label('Использован')
        ?>

    <?php } ?>

    <?= $form->field($model, 'mail_chimp_status')
        ->textInput(['value' => Subscriber::getMailChimpStatus()[$model->mail_chimp_status], 'maxlength' => true, 'disabled' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
