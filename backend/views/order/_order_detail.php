<?php

use common\models\Size;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii2mod\editable\EditableColumn;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'showFooter'=>false,
    'summary' => false,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'sku',
            'value' => function($model){
                return $model->item->stock_keeping_unit;
            },
            'label' => 'Артикул'
        ],
        [
            'attribute' => 'name',
            'value' => function($model){
                return $model->item->name;
            },
            'label' => 'Наименование'
        ],
        [
            'attribute' => 'color',
            'value' => function($model){
                return $model->item->color->name;
            },
            'label' => 'Цвет'
        ],
        [
            'class' => EditableColumn::className(),
            'attribute' => 'size',
            'url' => 'update-value',
            'type' => 'select',
            'value' => function($model){
                return Size::findOne($model->size)->value;
            },
            'editableOptions' => function ($model) {
                return [
                    'source' => ArrayHelper::map(
                        Size::find()
                            ->where(['in' , 'id',
                                $model->item->getPresentSizes()
                            ])
                            ->asArray()->all(), 'id', 'value'),
                    'value' => $model->size,
                ];
            },
        ],
        [
            'class' => EditableColumn::className(),
            'type' => 'number',
            'url' => 'update-value',
            'editableOptions' => function () {
                return [
                    'min' => 1,
                    'max' => 5,
                ];
            },
            'attribute' => 'quantity',
            'value' => function ($model, $key, $index, $widget) {
                return $model->quantity;
            },
            'label' => 'Количество',
            'options' => ['name' => 'quantity']
        ],
        [
            'attribute' => 'price',
            'format' => 'currency',
            'label' => 'Цена'
        ],

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $index) {
                    $id = explode('_', $index);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-item?id=' . $id[0] . '&item_id=' . $id[1], [
                        'title' => 'Удалить',
                    ]);
                }
            ],
        ],
    ],
]);
?>
