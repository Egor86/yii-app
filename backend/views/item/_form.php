<?php

use common\models\Color;
use common\models\Size;
use common\widgets\SeoForm;
use kartik\switchinput\SwitchInput;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
/* @var $product common\models\Product */
/** @var $item_sizes common\models\ItemSize */
/* @var $image_storages common\models\ImageStorage */

?>

<div class="item-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]); ?>

    <?= Html::activeHiddenInput($model, "product_id", [
        'value' => $product->id, 'id' => 'product_id', 'data-product-id' => $product->id]);?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'color_id')
                ->dropDownList(ArrayHelper::map(Color::find()->asArray()->all(), 'id', 'name')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'name', ['enableClientValidation' => true,])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'slug', ['enableClientValidation' => true,])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'stock_keeping_unit', ['enableClientValidation' => true,])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'price')->textInput()->widget(MaskedInput::className(),[
                'name' => 'price',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                    'alias' =>  'currency',
                    'autoGroup' => false,
                    'prefix' => false
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'discount_price')->textInput()->widget(MaskedInput::className(),[
                'name' => 'discount_price',
                'clientOptions' => [
                    'alias' =>  'currency',
                    'autoGroup' => false,
                    'prefix' => false
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->widget(SwitchInput::className(),['pluginOptions' => [
                'onText' => 'Да',
                'offText' => 'Нет',
            ]]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'recommended')->widget(SwitchInput::className(),['pluginOptions' => [
                'onText' => 'Да',
                'offText' => 'Нет',
            ]]) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => Size::getCount(), // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-size', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $item_sizes[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'size_id',
                    'amount',
                ],
            ]); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="pull-right add-size btn btn-success btn-xs"><i class="fa fa-plus"></i> Добавить размер</button>
                    <div class="clearfix"></div>
                </div>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($item_sizes as $index => $model_item_size): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (! $model_item_size->isNewRecord) {
                                echo Html::activeHiddenInput($model_item_size, "[{$index}]id");
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model_item_size, "[{$index}]size_id", ['enableClientValidation' => true,])
                                        ->dropDownList(ArrayHelper::map(Size::find()->asArray()->all(), 'id', 'value'), ['prompt' => '--']) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model_item_size, "[{$index}]amount")->textInput(['maxlength' => true])
                                        ->widget(MaskedInput::className(),[
                                        'name' => 'amount',
                                        'mask' => '9',
                                        'clientOptions' => [
                                            'repeat' => 10,
                                            'greedy' => false
                                        ]
                                    ])
                                    ; ?>
                                </div>
                            </div><!-- .row -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
    </div>
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <h3>SEO параметры</h3>

    <?= SeoForm::widget(['model' => $model]) ?>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?= $this->render('_image_form', [
        'form' => $form,
        'model' => $model,
        'image_storages' => $image_storages
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
