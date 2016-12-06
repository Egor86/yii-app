<?php

use common\models\Coupon;
use common\models\Order;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
if (Yii::$app->controller->action->id != 'index') {
    $this->title = 'Архив заказов';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => false,
            'columns' => [
    //            ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'id',
                    'filter'=> false,
                    'options' => [
                        'width' => '15px'
                    ]
                ],
                'name',
//                'surname',
    //            'country',
    //            'region',
//                 'city',
                 'address',
                // 'organization_name',
    //             'post_index',
                [
                    'attribute' => 'phone',
                    'filter' => false,
                ],
                 'email:email',
//                [
//                    'attribute' => 'delivery_date',
//                    'format' => 'date',
//                    'filter' => \yii\jui\DatePicker::widget([
//                        'attribute' => 'delivery_date',
//                        'model'=>$searchModel, 'dateFormat' => 'yyyy-MM-dd', 'language' => 'ru']),
//                ],
                [
                    'attribute' => 'delivery',
                    'value' => function ($model) {
                        return $model->delivery ? '<span class="label label-danger">Нужна</span>' : '<span class="label label-success">Не нужна</span>';
                    },
                    'format' => 'html',
                    'filter'=> ['Не нужна', 'Нужна'],
                ],
                [
                    'attribute' => 'status',
                    'value' => function($data){
                        return Order::getStatus()[$data->status];
                    },
                    'filter'=> Order::getStatus(),
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                    'filter' => false,
                ],
                'total_cost:currency',
    //             'updated_at:datetime',
                // 'sort_by',

                ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
