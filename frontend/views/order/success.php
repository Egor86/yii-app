<?php

use yii\widgets\DetailView;

/** @var object $model common\models\Order*/
//echo '<pre>';
//@print_r($model->coupon);
//echo '</pre>';
//exit(__FILE__ .': '. __LINE__);
echo DetailView::widget([
        'model' => $model,
            'attributes' => [
                'fullName',
                'fullAddress',
                'phone',
                'delivery_date',
                [
                    'attribute' => 'coupon_code',
                    'value' => $model->coupon ? $model->coupon->coupon_code : ''
                ],
                [
                    'attribute' => 'total_cost',
                    'value' => $model->coupon ? $model->total_cost - $model->coupon->discount : $model->total_cost,
                    'format' => 'currency'
                ],
            ]
        ]);

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'showPageSummary' => true,
    'striped' => true,
    'export' => false,
    'summary' => false,
    'resizableColumns'=>false,
    'columns' => [
        ['class'=>'kartik\grid\SerialColumn'],

        [
            'attribute'=>'Name',
            'width'=>'100px',
            'value' => function($model, $key, $index, $widget) {
                return $model->item->name;
            },
            'label' => 'Наименование товара'
        ],
        [
            'attribute'=>'color',
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) {
                return \common\models\Color::findOne($model->color)->name;
            },
            'label' => 'Цвет'
        ],
        [
            'attribute' => 'size',
            'value' => function ($model, $key, $index, $widget) {
                return \common\models\Size::findOne($model->size)->value;
            },
            'label' => 'Размер',
        ],
        [
            'attribute' => 'price',
            'value' => function ($model, $key, $index, $widget) {
                if ($model->item->discount_price > 0) {
                    return $model->item->discount_price;
                }
                return $model->item->price;
            },
            'label' => 'Цена',
            'width' => '150px',
            'format' => 'currency',
            'hAlign'=>'right',
            'pageSummary' => 'Всего'
        ],
        [
            'attribute' => 'quantity',
            'value' => function ($model, $key, $index, $widget) {
                return $model->quantity;
            },
            'label' => 'Количество',
            'hAlign'=>'right',
            'pageSummary' => true
        ],
    ],
]);
