<?php

/** @var $items common\models\Item*/
use common\models\Color;
use common\models\Item;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

?>

<?php foreach ($items as $model) : ?>
<p>
    <h4><a class="dashed-link collapsed" data-toggle="collapse" href="#item-view<?= $model->id?>" aria-expanded="false" aria-controls="item-view<?= $model->id?>"><?= $model->name?></a></h4>
</p>
<div class="collapse" id="item-view<?= $model->id?>" class="item-view">

    <p>
        <?= Html::a('Размеры и количество', ['/item-size/update', 'item_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изображения', ['/item/update-image', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'container' => ['id'=>'kv-demo'],
        'formOptions' => [
            'action' => Url::to('/admin/item/update?id='.$model->id),
            'options' => ['enctype' => 'multipart/form-data']
        ],
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'# ' . $model->id.' '.$model->name,
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
                        'value' => "<span class='badge' style='background-color: {$model->color->rgb_code}'> </span> " . $model->color->name,
                        'updateMarkup' => function($form, $widget) {
                            $model = $widget->model;
                            $color_list = Item::find()->select('color_id')
                                ->where(['product_id' => $model->product_id])
                                ->andWhere(['not', ['id' => $model->id]])->asArray()->column();
                            return $form->field($model, 'color_id')
                                ->dropDownList(ArrayHelper::map(Color::find()
                                    ->where(['not in', 'id', $color_list])
                                    ->asArray()->all(), 'id', 'name'));
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
                'group'=>true,
                'label'=>'Seo параметры',
                'rowOptions'=>['class'=>'info'],
                'groupOptions'=>['class'=>'text-center']
            ],
            [
                'columns' => [
                    [
                        'label' => 'Seo title',
                        'value' => $model->seo->title,
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'label' => 'Seo keyword',
                        'value' => $model->seo->keyword,
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'Seo',
                'label' => 'Seo description',
                'value' => $model->seo->description,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return \common\widgets\SeoForm::widget(['model' => $model]);
                },
//                'rowOptions' => ['class'=>'kv-edit-hidden', 'style' => 'float: left'],
                'valueColOptions'=>['style'=>'width:70%'],
            ],
        ],
        'deleteOptions' => [
            'url' => 'delete',
            'params' => ['id' => $model->id]],
    ]) ?>
</div>
<?php endforeach;?>