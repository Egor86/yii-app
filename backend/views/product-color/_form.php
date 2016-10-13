<?php

use common\models\Color;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */
/* @var $form yii\widgets\ActiveForm */
/* @var $product common\models\Product */
/* @var $product_color_size common\models\ProductColorSize */
?>

<div class="product-color-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($product, 'name')->textInput(['maxlength' => true, 'value' => $product->name, 'disabled' => true]) ?>
        </div>
    </div>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => Color::getCount(),
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $model[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'adding_sizes',

        ],
    ]); ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Цвета</th>
            <th style="width: 700px;">Размеры и их количество</th>
            <th class="text-center" style="width: 90px;">
                <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($model as $indexProductColor => $modelProductColor): ?>
            <tr class="house-item">
                <td class="vcenter">


                    <?= Html::activeHiddenInput($modelProductColor, "[{$indexProductColor}]product_id", [
                        'value' => $product->id, 'id' => 'product_id', 'data-product-id' => $product->id]);?>

                    <?php
                    // necessary for update action.
                    if (! $modelProductColor->isNewRecord) {
                        echo Html::activeHiddenInput($modelProductColor, "[{$indexProductColor}]id", ['data-product-color-id' => '']);
                    }
                    ?>

                    <?= $form->field($modelProductColor, "[{$indexProductColor}]color_id")->label(false)
                        ->dropDownList(ArrayHelper::map(Color::find()->asArray()->all(), 'id', 'name')) ?>
                </td>
                <td>
                    <?= $this->render('_form-size', [
                        'form' => $form,
                        'indexProductColor' => $indexProductColor,
                        'modelsProductColorSize' => $product_color_size[$indexProductColor],
                    ]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($model[0]->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
