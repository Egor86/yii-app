<?php

use kartik\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'toolbar' => false,
    'pjax' => true,
    'striped' => true,
    'hover' => false,
    'export' => false,
    'summary' => false,
    'resizableColumns' => false,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'item.color.name',
            'width' => '310px',
            'group' => true,
        ],
        [
            'attribute' => 'size.value',
            'width' => '250px',
            'pageSummary' => 'Итого:',
            'pageSummaryOptions' => ['class'=>'text-center text-warning'],
        ],
        [
            'attribute' => 'amount',
            'pageSummaryOptions' => ['class'=>'text-left text-warning'],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],

        [
            'class' => '\kartik\grid\ActionColumn',
            'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>'],
        ]
    ],
]);
?>
