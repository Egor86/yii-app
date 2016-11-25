<?php

use common\helpers\Image;
use common\models\Color;
use common\models\ImageStorage;
use common\models\Item;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <p>

        <?= Html::a('<i class="fa fa-arrow-left"></i> Родительский продукт: '. $model->product->name,
            ['/product/view', 'id' => $model->product_id],
            ['class' => "btn btn-success btn-s"])?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => false,
        'container' => ['id'=>'kv-demo'],
        'formOptions' => [
            'action' => Url::to('/admin/item/update?id='.$model->id),
            'options' => ['enctype' => 'multipart/form-data']
        ],
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'# ' . $model->id . ' '. $model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'columns' => [
                    [
                        'attribute' => 'name',
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute' => 'color_id',
                        'format' => 'raw',
                        'value' => ($model->color->type == Color::COLOR_RGB ?
                                "<span class='badge' style='background-color: {$model->color->rgb_code}'> </span>" :
                                (($img = ImageStorage::findOne(['class' => get_class($model->color),'class_item_id' => $model->color->id])) ?
                                    Html::img(Image::thumb($img->file_path, Yii::getAlias('@front-web'), 40, 40)) : 'Изображение отсутствует '))
                            . " " . $model->color->name,
                        'updateMarkup' => function($form, $widget) {
                            $model = $widget->model;
//                            $color_list = Item::find()->select('color_id')
//                                ->where(['product_id' => $model->product_id])
//                                ->andWhere(['not', ['id' => $model->id]])->asArray()->column();
                            return $form->field($model, 'color_id')
                                ->dropDownList(ArrayHelper::map(Color::find()->all(), 'id', 'name'));
                        },
                        'valueColOptions' => ['style'=>'width:30%'],
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'slug',
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute' => 'stock_keeping_unit',
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'price',
                        'format' => 'currency',
                        'updateMarkup' => function($form, $widget) {
                            $model = $widget->model;
                            return $form->field($model, 'price')->textInput()->widget(MaskedInput::className(),[
                                'name' => 'price',
                                'clientOptions' => [
                                    'alias' =>  'currency',
                                    'autoGroup' => false,
                                    'prefix' => false
                                ],
                            ]);
                        },
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute' => 'discount_price',
                        'format' => 'currency',
                        'updateMarkup' => function($form, $widget) {
                            $model = $widget->model;
                            return $form->field($model, 'discount_price')->textInput()->widget(MaskedInput::className(),[
                                'name' => 'price',
                                'clientOptions' => [
                                    'alias' =>  'currency',
                                    'autoGroup' => false,
                                    'prefix' => false
                                ],
                            ]);
                        },
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'created_at',
                        'displayOnly' => true,
                        'format' => 'datetime',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'displayOnly' => true,
                        'format' => 'datetime',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                ],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'status',
                        'format'=>'raw',
                        'value'=>$model->status ? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Да',
                                'offText' => 'Нет',
                            ]
                        ]
                    ],
                    [
                        'attribute' => 'recommended',
                        'format'=>'raw',
                        'value'=>$model->recommended ? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Да',
                                'offText' => 'Нет',
                            ]
                        ]
                    ],
                ]
            ],
            [
                'label' => 'Количество',
                'format'=>'raw',
                'value' => $model->getAmount() ? '<span class="label label-success">' . $model->getAmount() . '</span>' : '<span class="label label-danger">Нет в наличии</span>',
                'rowOptions'=>['class'=>'kv-edit-hidden']
            ],
            [
                'group'=>true,
                'label'=>'Seo параметры',
                'rowOptions'=>['class'=>'info'],
                'groupOptions'=>['class'=>'text-center']
            ],
            [
                'columns' => [
                    [
                        'label' => 'Seo title',
                        'value' => $model->seo ? $model->seo->title : '',
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'label' => 'Seo keyword',
                        'value' => $model->seo ? $model->seo->keyword : '',
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'Seo',
                'label' => 'Seo description',
                'value' => $model->seo ? $model->seo->description : '',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return \common\widgets\SeoForm::widget(['model' => $model]);
                },
//                'rowOptions' => ['class'=>'kv-edit-hidden', 'style' => 'float: left'],
                'valueColOptions'=>['style'=>'width:80%'],
                'labelColOptions'=>['class'=>'kv-edit-hidden', 'style'=>'float: right'],
            ],
        ],
        'deleteOptions' => [
            'url' => '/admin/item/delete',
            'params' => ['id' => $model->id],
        ]
    ]) ?>

</div>

    <div class="panel panel-info">
        <div class="panel-heading"style='text-align: center'><span style="color: #000000; font-weight: bold">Размеры и их количество</span></div>
        <div class="panel-body">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'size_id',
            'value' => function($model) {
                return $model->size->value;
            },
        ],
        'amount',

    ],
]); ?>
<?= Html::a('Обновить размеры и количество', ['/item-size/update', 'item_id' => $model->id], ['class' => 'pull-left btn btn-success btn-xs']) ?>

        </div>
    </div>

<?php
function getImg($model, $type)
{
    $images = ImageStorage::findAll(['class' => get_class($model), 'class_item_id' => $model->id,  'type' => $type]);
    $show = [];
    if (!empty($images)) {
        if (count($images) > 1) {
            foreach ($images as $img) {
                if (is_file(Yii::getAlias('@front-web') . $img->file_path)) {
                    $show[] = Html::img($img->file_path, ['width' => 'auto', 'height' => 100]);
                }
            }
            return implode(' ', $show);
        }
        return is_file(Yii::getAlias('@front-web') . $images[0]->file_path) ? Html::img($images[0]->file_path, ['width' => 'auto', 'height' => 100]) : 'Загруженное изображение не найдено';
    }
    return 'отсутствует(ют)';
}
?>
<div class="panel panel-info">
    <div class="panel-heading"style='text-align: center'><span style="color: #000000; font-weight: bold">Изображения</span></div>
    <div class="panel-body">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Основное фото',
            'value' => getImg($model,ImageStorage::TYPE_MAIN),
            'format' => 'html'
        ],
        [
            'label' => 'Второе основное фото',
            'value' => getImg($model,ImageStorage::TYPE_SECOND_MAIN),
            'format' => 'html'
        ],
        [
            'label' => 'Остальные фото',
            'value' => getImg($model,ImageStorage::TYPE_OTHER),
            'format' => 'html'
        ],
    ],
]) ?>
    <?= Html::a('Обновить изображения', ['/item/update-image', 'id' => $model->id], ['class' => 'pull-left btn btn-success btn-xs']) ?>
    </div>
</div>