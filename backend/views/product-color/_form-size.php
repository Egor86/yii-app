<?php

use common\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => Size::getCount(),
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsProductColorSize[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'adding_sizes'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Укажите количество</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-rooms">
        <?php foreach ($modelsProductColorSize as $indexProductColorSize => $modelProductColorSize): ?>
            <tr class="room-item">
                <td class="vcenter">
                    <?php
                    // necessary for update action.
                    if (! $modelProductColorSize->isNewRecord) {
                        echo Html::activeHiddenInput($modelProductColorSize, "[{$indexProductColor}][{$indexProductColorSize}]id");
                    }
                    ?>
                     <?= $form->field($modelProductColorSize, "[{$indexProductColor}][{$indexProductColorSize}]size_id")->dropDownList(ArrayHelper::map(Size::find()->asArray()->all(), 'id', 'value')) ?>
                    <?= $form->field($modelProductColorSize, "[{$indexProductColor}][{$indexProductColorSize}]amount")->textInput(['maxlength' => true]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>