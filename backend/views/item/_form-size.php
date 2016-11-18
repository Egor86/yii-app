<?php

use common\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var $item_sizes common\models\ItemSize*/
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-sizes',
    'widgetItem' => '.size-item',
    'limit' => Size::getCount(),
    'min' => 1,
    'insertButton' => '.add-size',
    'deleteButton' => '.remove-size',
    'model' => $item_sizes[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'adding_sizes'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Укажите размер и количество</th>
            <th class="text-center">
                <button type="button" class="add-size btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-sizes">
        <?php foreach ($item_sizes as $indexItemSize => $modelItemSize): ?>
            <tr class="size-item">
                <td class="vcenter">
                    <?php
                    // necessary for update action.
                    if (! $modelItemSize->isNewRecord) {
                        echo Html::activeHiddenInput($modelItemSize, "[{$indexItemSize}]id");
                    }
                    ?>
                     <?= $form->field($modelItemSize, "[{$indexItemSize}]size_id")->dropDownList(ArrayHelper::map(Size::find()->asArray()->all(), 'id', 'value')) ?>
                    <?= $form->field($modelItemSize, "[{$indexItemSize}]amount")->textInput(['maxlength' => true]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-size btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>