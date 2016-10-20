<?php

use common\models\Product;
use common\widgets\SeoForm;
use kartik\file\FileInput;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $video_form backend\models\VideoForm */

?>
<?php
//$this->registerJs("
//function setItemImagePreview(el) {
//    $.post('" . Url::to(['file/set-item-image-preview']) . "', { id: $(el).data('key') }, function(data) {
//        $('.b-item-image-preview').removeClass('b-item-image-preview');
//        $(el).closest('.file-preview-frame').addClass('b-item-image-preview');
//    }, 'json');
//}
//", \yii\web\View::POS_HEAD);
?>
<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(\vova07\imperavi\Widget::className(),[
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'brand_id')
        ->dropDownList(ArrayHelper::map(\common\models\Brand::find()
            ->all(), 'id', 'name'),$model->brand_id ? [
            'options' => [$model->brand_id => ['selected' => 'selected']]] : ['prompt' => '--']) ?>
    <?php if(!$model->video || !$model->video->url) { ?>
    <?= $form->field($video_form, 'videoFile')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'video/*',
        ],
        'pluginOptions' => [
            'maxFileCount' => 1,
            'showRemove' => true,
            'showUpload' => false,
            'showCaption' => false,
            'overwriteInitial' => false,
        ],
    ]) ?>
    <?php } else { ?>

        <?= "<iframe width='480' height='270' src='".$model->video->url."' frameborder='0' allowfullscreen></iframe>";?>

        <?= Html::a('Удалить видео', ['/product/delete-video?id='.$model->id], ['class'=>'product-form btn btn-primary']) ?>

    <?php } ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(\common\models\Category::find()
        ->all(), 'id', 'name'),$model->category_id ? [
        'options' => [$model->category_id => ['selected' => 'selected']]] : ['prompt' => '--']) ?>

    <?= $form->field($model, 'stock_keeping_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->widget(SwitchInput::classname(), ['pluginOptions' => [
        'onText' => 'Да',
        'offText' => 'Нет',
    ]]); ?>

    <?= SeoForm::widget(['model' => $model]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
