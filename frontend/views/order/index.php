<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form ActiveForm */
?>
<div class="cart-index">

    <?php $form = ActiveForm::begin(['action' => '/order/confirm.html']); ?>

        <?= $form->field($model, 'name')->input('text', ['style' => 'width: 300px'] ) ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'delivery_date')->input('date', ['style' => 'width: 300px']    ) ?>
        <?= $form->field($model, 'coupon_code') ?>
        <?= $form->field($model, 'surname') ?>
        <?= $form->field($model, 'country') ?>
        <?= $form->field($model, 'region') ?>
        <?= $form->field($model, 'organization_name') ?>
        <?= $form->field($model, 'post_index') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <?//= \kartik\grid\GridView::widget()?>
</div><!-- cart-index -->
