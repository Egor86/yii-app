<?php
use common\models\ImageStorage;
use common\models\Product;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model common\models\Product */
/* @var $multiple_form backend\models\VideoForm */
$this->registerJs("
function setItemImagePreview(el) {
    $.post('" . Url::to(['image/set-item-image-preview']) . "', { id: $(el).data('key') }, function(data) {
        $('.b-item-image-preview').removeClass('b-item-image-preview');
        $(el).closest('.file-preview-frame').addClass('b-item-image-preview');
    }, 'json');
}

", \yii\web\View::POS_HEAD);
?>

<?= Html::a('Вернутся к продукту', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <div class="product-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= $form->field($multiple_form, 'imageMain')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                    'uploadAsync' => false,
                ],
                'pluginOptions' => [
                    'uploadUrl' => '/admin/product/add-images?id='.$model->id,
                    'uploadAsync' => false,
                    'maxFileCount' => 1,
                    'showRemove' => true,
                    'showUpload' => true,
                    'showCaption' => false,
                    'overwriteInitial' => false,
                    'initialPreview' => ImageStorage::getInitialPreview($model, ImageStorage::TYPE_MAIN),
                    'initialPreviewConfig' => ImageStorage::getInitialPreviewConfig($model, ImageStorage::TYPE_MAIN),
//                    'otherActionButtons' => '<button onclick="setItemImagePreview(this)" type="button" class="btn btn-default btn-xs js-set-item-image-preview" {dataKey}><span class="glyphicon glyphicon-star"></span></button>'
                ],
            ]) ?>

            <?= $form->field($multiple_form, 'imageSecondMain')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                    'uploadAsync' => false,
                ],
                'pluginOptions' => [
                    'uploadUrl' => '/admin/product/add-images?id='.$model->id,
                    'uploadAsync' => false,
                    'maxFileCount' => 1,
                    'showRemove' => true,
                    'showUpload' => true,
                    'showCaption' => false,
                    'overwriteInitial' => false,
                    'initialPreview' => ImageStorage::getInitialPreview($model, ImageStorage::TYPE_SECOND_MAIN),
                    'initialPreviewConfig' => ImageStorage::getInitialPreviewConfig($model, ImageStorage::TYPE_SECOND_MAIN),
    //                    'otherActionButtons' => '<button onclick="setItemImagePreview(this)" type="button" class="btn btn-default btn-xs js-set-item-image-preview" {dataKey}><span class="glyphicon glyphicon-star"></span></button>'
                ],
            ]) ?>

            <?= $form->field($multiple_form, 'imageOther[]')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                    'uploadAsync' => true,
                ],
                'pluginOptions' => [
                    'uploadUrl' => '/admin/product/add-images?id='.$model->id,
                    'uploadAsync' => true,
                    'maxFileCount' => 10,
                    'showRemove' => true,
                    'showUpload' => true,
                    'showCaption' => false,
                    'overwriteInitial' => false,
                    'initialPreview' => ImageStorage::getInitialPreview($model, ImageStorage::TYPE_OTHER),
                    'initialPreviewConfig' => ImageStorage::getInitialPreviewConfig($model, ImageStorage::TYPE_OTHER),
//                    'otherActionButtons' => '<button onclick="setItemImagePreview(this)" type="button" class="btn btn-default btn-xs js-set-item-image-preview" {dataKey}><span class="glyphicon glyphicon-star"></span></button>'
                ],
            ]) ?>
        <?php ActiveForm::end(); ?>
    </div>
