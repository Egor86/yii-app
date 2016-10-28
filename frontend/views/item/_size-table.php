<?php

/* @var $this yii\web\View */
/** @var object $model common\model\Product*/
/** @var array $dataProvider ArrayDataProvider*/

use common\models\Category;
use yii\grid\GridView;

$sizeTableName = Category::findOne($model->product->category_id)->sizeTableName->name;

if ($sizeTableName == 'wear_size_table') {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns'=>[
            [
                'attribute' => 'size',
                'label' => 'Размер'
            ],
            [
                'attribute' => '34/XS/42',
                'label' => '34/XS/42'
            ],
            [
                'attribute' => '36/S/44',
                'label' => '36/S/44'
            ],
            [
                'attribute' => '38/M/46',
                'label' => '38/M/46'
            ],
            [
                'attribute' => '40/L/48',
                'label' => '40/L/48'
            ],
            [
                'attribute' => '42/XL/50',
                'label' => '42/XL/50'
            ],
            [
                'attribute' => '44/XXL/52',
                'label' => '44/XXL/52'
            ],
            [
                'attribute' => '46/XXXL/54',
                'label' => '46/XXXL/54'
            ],
        ],
    ]);
} elseif ($sizeTableName == 'shoes_size_table') {
    echo 'shoes_size_table';
}