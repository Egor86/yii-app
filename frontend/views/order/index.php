<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form ActiveForm */

?>
<div class="cart-index">

    <?php $form = ActiveForm::begin(['action' => '/order/confirm.html']); ?>

        <?= $form->field($model, 'name')->input('text', ['style' => 'width: 300px', 'value' => $model->name, 'disabled' => $model->name ? true : false]) ?>

        <?= $form->field($model, 'surname') ?>

        <?= $form->field($model, 'country') ?>

        <?= $form->field($model, 'region') ?>

        <?= $form->field($model, 'city') ?>

        <?= $form->field($model, 'address') ?>

        <?php if ($model->phone) {
                echo $form->field($model, 'phone')->textInput(['value' => $model->phone, 'disabled' => true]) ;
            } else {
                echo $form->field($model, 'phone')->textInput(['value' => $model->phone])->widget(\yii\widgets\MaskedInput::className(),[
                'name' => 'phone',
                'mask' => '(999) 999-99-99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ]]);
            } ?>

        <?php if ($model->email) {
                echo $form->field($model, 'email')->textInput(['value' => $model->email, 'disabled' => true]) ;
            } else {
                echo $form->field($model, 'email')->textInput(['value' => $model->email])->widget(\yii\widgets\MaskedInput::className(), [
                'name' => 'email',
                'clientOptions' => ['alias' =>  'email']
            ]);
        } ?>

        <?= $form->field($model, 'delivery_date')->widget(\yii\jui\DatePicker::className(),[]) ?>

        <?= $form->field($model, 'organization_name') ?>

        <?= $form->field($model, 'post_index') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- cart-index -->
