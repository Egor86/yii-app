<?php

use common\models\Size;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\ItemSize */
/* @var $item common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="item-size-form">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="padding-v-md">
    <div class="line line-dashed"></div>
</div>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => Size::getCount($item->product_id), // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $models[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'full_name',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
    ],
]); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::a('<i class="fa fa-arrow-left"></i> Вернуться', ['/item/view', 'id' => $item->product_id], ['class' => "pull-left btn btn-success btn-xs"])?>
        <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Добавить размер</button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body container-items"><!-- widgetContainer -->
        <?php foreach ($models as $index => $model): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">

                    <?php
                    // necessary for update action.
                    if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, "[{$index}]id", ['data-item-size-id' => $model->id]);
                    }
                    ?>

                    <?= Html::activeHiddenInput($model, "[{$index}]item_id", [
                        'value' => $item->id, 'id' => 'item_id', 'data-item-id' => $item->id]);?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, "[{$index}]size_id")->dropDownList(ArrayHelper::map($item->getSizeTable(), 'id', 'value')) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, "[{$index}]amount")->textInput(['maxlength' => true])->widget(MaskedInput::className(),[
                                'name' => 'amount',
                                'mask' => '9',
                                'clientOptions' => [
                                    'repeat' => 10,
                                    'greedy' => false
                                ]
                            ]); ?>
                        </div>
                    </div><!-- end:row -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php DynamicFormWidget::end(); ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
