<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_index')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->widget(\yii\widgets\MaskedInput::className(),[
        'name' => 'phone',
        'mask' => '(999) 999-99-99'
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->widget(\yii\widgets\MaskedInput::className(),[
        'name' => 'email',
        'clientOptions' => ['alias' =>  'email']
    ]) ?>

    <?= $form->field($model, 'delivery_date')->widget(DatePicker::classname(),
        [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ])
     ?>

    <?= $form->field($model, 'coupon_id')->textInput(['value' => $model->coupon_id ? $model->coupon->coupon_code : '', 'disabled' => $model->coupon_id ? true : false]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
