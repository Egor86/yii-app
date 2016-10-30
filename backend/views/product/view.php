<?php

use common\models\Brand;
use common\models\Category;
use kartik\detail\DetailView;
use kartik\file\FileInput;
use kartik\grid\GridView;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/** @var $items common\models\Item*/

BootstrapPluginAsset::register($this);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'formOptions' => [
            'action' => Url::to('update?id='.$model->id),
            'options' => ['enctype' => 'multipart/form-data']
        ],
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'# ' . $model->id.' '.$model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'name',
            [
                'attribute' => 'description',
                'type'=>DetailView::INPUT_TEXTAREA,
            ],
            [
                'attribute' => 'brand_id',
                'value' => $model->brand->name,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brand::find()
                        ->all(), 'id', 'name'));
                }
            ],
            [
                'attribute' => 'video_id',
                'value' => $model->video ? $model->video->file_name : '',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    if ($model->video_id) {
                        return Html::a('Удалить видео', ['/product/delete-video?id='.$model->id], ['class'=>'product-form btn btn-primary']);
                    }
                    $video_form = new \backend\models\VideoForm();
                    return $form->field($video_form, 'videoFile')->widget(FileInput::classname(), [
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
                    ]);
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()
                        ->all(), 'id', 'name'));
                }
            ],
            [
                'attribute' => 'created_at',
                'displayOnly' => true,
                'format' => 'datetime'
            ],
            [
                'attribute' => 'updated_at',
                'displayOnly' => true,
                'format' => 'datetime'
            ],
            [
                'attribute' => 'published',
                'format'=>'raw',
                'value'=>$model->published ? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>',
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
                ]
            ],
        ],
        'deleteOptions' => [
            'url' => 'delete',
            'params' => ['id' => $model->id]],
    ]) ?>
</div>

<?= Html::a('Созадать дочерний товар', ['/item/create', 'product_id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?= $this->render('//item/_items', ['items' => $items])?>

