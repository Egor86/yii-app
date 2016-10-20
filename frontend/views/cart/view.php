<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii2mod\editable\EditableColumn;

$this->registerJs("
$(document).ready(function () {
    $(\"a[name='quantity']\");

});

", \yii\web\View::POS_READY);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'striped' => true,
//    'showPageSummary' => true,
    'hover' => true,
    'export' => false,
    'summary' => false,
    'resizableColumns'=>false,
    'columns'=>[
        [
            'class'=>'kartik\grid\SerialColumn',
            'width'=>'5px',
        ],
        [
            'attribute'=>'Name',
            'width'=>'100px',
            'value' => function($model, $key, $index, $widget) {
                return $model->product->name;
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
                if ($model->product->discount_price > 0) {
                    return $model->product->discount_price;
                }
                return $model->product->price;
            },
            'label' => 'Цена',
            'width' => '150px',
            'format' => 'currency',
            'hAlign'=>'right',
            'pageSummary' => 'Всего'
        ],
        [
            'class' => EditableColumn::className(),
            'type' => 'number',
            'url' => ['/cart/update'],
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
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
        ],
    ],
]);

echo Html::a('Оформить заказ', '/order/confirm.html', ['class' => 'btn btn-primary']);

echo 'Сумма заказа: '.Yii::$app->cart->getCost().' UAH';