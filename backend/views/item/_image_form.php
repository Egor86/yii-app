<?php

/* @var $image_storages common\models\ImageStorage */
/* @var $model common\models\Item */
/* @var $this yii\web\View */

use common\models\ImageStorage;
use kartik\file\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\jui\JuiAsset;

?>
<div id="panel-option-values" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-picture"></i> Изображения для товара</h3>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.form-options-body',
        'widgetItem' => '.form-options-item',
        'min' => 1,
        'insertButton' => '.add-image',
        'deleteButton' => '.delete-item',
        'model' => $image_storages[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'type',
            'image'
        ],
    ]); ?>

<table class="table table-bordered table-striped margin-b-none">
    <thead>
    <tr>
        <th style="width: 90px; text-align: center">#</th>
        <th class="required">Тип изображения</th>
        <th style="width: 288px;">Изображение</th>
        <th style="width: 90px; text-align: center">Действия</th>
    </tr>
    </thead>
    <tbody class="form-options-body">
    <?php foreach ($image_storages as $index => $image_storage): ?>
        <tr class="form-options-item">
            <td class="text-center vcenter">
                <span class="image-number"><?= ($index + 1) ?></span>
            </td>
            <td class="vcenter">
                <div class="col-sm-6">
                <?= $form->field($image_storage, "[{$index}]type")->label(false)->dropDownList(\common\models\ImageStorage::getTypeList(), ['prompt' => "--", 'required' => true])
                    ->hint('Тип изображения "Основное" и "Второе основое" может быть присвоен только одному изображению');
                ?>
                </div>
            </td>
            <td>
                <?php if (!$image_storage->isNewRecord): ?>
                    <?= Html::activeHiddenInput($image_storage, "[{$index}]id"); ?>
                    <?= Html::activeHiddenInput($image_storage, "[{$index}]file_path"); ?>
                    <?= Html::activeHiddenInput($image_storage, "[{$index}]deleteImg"); ?>
                <?php endif; ?>
                <?php
                $initialPreview = [];
                if ($image_storage->file_path) {
                    $initialPreview[] = Html::img($image_storage->file_path, ['width' => 'auto', 'height' => 100, 'class' => 'file-preview-image']);
                }
                ?>
                <?= $form->field($image_storage, "[{$index}]image")->label(false)->widget(FileInput::classname(), [
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*',
                        'class' => 'imagestorage-img',
                    ],
                    'pluginOptions' => [
                        'previewFileType' => 'image',
                        'clearFix' => false,
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-default btn-sm',
                        'browseLabel' => ' Выбрать',
                        'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                        'removeClass' => 'btn btn-danger btn-sm',
                        'removeLabel' => ' Delete',
                        'removeIcon' => '<i class="fa fa-trash"></i>',
                        'previewSettings' => [
                            'image' => ['width' => '138px', 'height' => 'auto']
                        ],
                        'initialPreview' => $initialPreview,
                        'layoutTemplates' => ['footer' => '']
                    ]
                ]) ?>

            </td>
            <td class="text-center vcenter">
                <button type="button" class="delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i> Удалить</button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td><button type="button" class="add-image btn btn-success btn-sm"><span class="fa fa-plus"></span> Добавить</button></td>
    </tr>
    </tfoot>
</table>
<?php DynamicFormWidget::end(); ?>
</div>

<?php
$js = '
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $(item).find(".file-initial-thumbs").remove();
    $(item).find(".file-input").addClass("file-input-new");
    $(item).find("option:selected").attr("selected", false);
    $(".dynamicform_wrapper .image-number").each(function(index) {
        $(this).html((index + 1))
    });
});
$("#dynamic-form").on("submit", function(e) {
    var form = $("#dynamic-form").serializeArray();
    
    var reg = /^ImageStorage\[[0-9]+\]\[type\]$/;
    var types = [];
    var unique = ['. ImageStorage::TYPE_MAIN .', '. ImageStorage::TYPE_SECOND_MAIN . '];
    for (key in form) {
        if (form[key].name.match(reg) !== null) {
            if ($.inArray(parseInt(form[key].value), types) != -1 && $.inArray(parseInt(form[key].value), unique) != -1 ) {
                $("[name=\'" + form[key].name + "\']").siblings(".help-block").text("Данный тип изображения уже указан").css("color", "red");
                e.preventDefault();
                return false;
            }
            types.push(parseInt(form[key].value));
        }
    }
    return true;
});
$(".dynamicform_wrapper").on("afterDelete", function(e) {
    $(".dynamicform_wrapper .image-number").each(function(index) {
        $(this).html((index + 1))
    });
});
//$(".imagestorage-img").on("filecleared", function(event) {
//    var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
//    var id = event.target.id;
//    var matches = id.match(regexID);
//    if (matches && matches.length === 4) {
//        var identifiers = matches[2].split("-");
//        $("#imagestorage-" + identifiers[1] + "-deleteimg").val("1");
//    }
//});
//
//var fixHelperSortable = function(e, ui) {
//    ui.children().each(function() {
//        $(this).width($(this).width());
//    });
//    return ui;
//};
//
//$(".form-options-body").sortable({
//    items: "tr",
//    cursor: "move",
//    opacity: 0.6,
//    axis: "y",
//    handle: ".sortable-handle",
//    helper: fixHelperSortable,
//    update: function(ev){
//        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
//    }
//}).disableSelection();
';

JuiAsset::register($this);
$this->registerJs($js);
?>
<script>

//    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
//        console.log(item);
//        item.find(".file-initial-thumbs").remove();
//    });
</script>