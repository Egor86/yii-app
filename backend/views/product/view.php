<?php

use backend\models\VideoForm;
use common\models\Brand;
use common\models\Category;
use kartik\detail\DetailView;
use kartik\file\FileInput;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/** @var $items common\models\Item*/

BootstrapPluginAsset::register($this);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
$(".video").click(function(event){ // нажатие на кнопку - выпадает модальное окно
        event.preventDefault(); 
    
        $.ajax({
            url: "/admin/product/get-video?id='. $model->id . '",
            type: "get",
            success: function (data) {
                if(data) {
                    $("source").attr("src", data);
                    $("video").load();
                    var clickedbtn = $(this);         
                    var modalContainer = $("#my-modal");
                    var modalBody = modalContainer.find(".modal-body");
                    modalContainer.modal({show:true});
                }
            }
        });  
    });
', \yii\web\View::POS_END);

?>
<div class="product-view">


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
                'format' => 'html',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'description')->widget(\vova07\imperavi\Widget::className(),[
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 200,
                            'plugins' => [
                                'clips',
                                'fullscreen'
                            ]
                        ]
                   ]);
                }
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
                'format' => 'html',
                'value' => $model->video && file_exists(Yii::getAlias('@front-web') . $model->video->url) ? '<div class="video"><a href="#" ><i class="fa fa-file-video-o"></i> Смотреть видео</a></div>'
                    : '',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    if ($model->video_id) {
                        return Html::a('Удалить видео', ['/product/delete-video?id='.$model->id], ['class'=>'product-form btn btn-primary']);
                    }
                    $video_form = new VideoForm();
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
                    return $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(
                        Category::find()->where(['not', ['parent' => 0]])->all(), 'id', 'name'));
                }
            ],
            [
                'attribute' => 'created_at',
                'displayOnly' => true,
                'format' => 'datetime',
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'updated_at',
                'displayOnly' => true,
                'format' => 'datetime',
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
//            [
//                'attribute' => 'published',
//                'format'=>'raw',
//                'value'=>$model->published ? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>',
//                'type' => DetailView::INPUT_SWITCH,
//                'widgetOptions' => [
//                    'pluginOptions' => [
//                        'onText' => 'Да',
//                        'offText' => 'Нет',
//                    ]
//                ]
//            ],
        ],
        'deleteOptions' => [
            'url' => 'delete',
            'params' => ['id' => $model->id]],
    ]) ?>
</div>
<div class="panel panel-info">
    <div class="panel-heading"style='text-align: center'><span style="color: #000000; font-weight: bold">Дочерние товары</span></div>
    <div class="panel-body">
    <?php foreach ($items as $item) : ?>
        <h4>
            <?= Html::a("<i class=\"fa fa-caret-square-o-right\"> $item->name</i>", ['/item/view', 'id' => $item->id])?>
        </h4>
    <?php endforeach;?>
        <?= Html::a('Созадать дочерний товар', ['/item/create', 'product_id' => $model->id], ['class' => 'pull-left btn btn-success btn-xs']) ?>

    </div>
</div>
<div id="item"></div>

<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 450px; height=350px">
        <div class="modal-content">
            <div class="modal-body" >
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="gb-user-form">
                    <video width="400" height="300" controls="controls">
                        <source src="">
                    </video>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->'