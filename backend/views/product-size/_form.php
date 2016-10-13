<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSize */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-size-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'size_id')
        ->dropDownList(ArrayHelper::map(\common\models\Size::find()->asArray()->all(), 'id', 'value')) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'color_ids')
        ->checkboxList(ArrayHelper::map(\common\models\Color::find()->asArray()->all(), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
