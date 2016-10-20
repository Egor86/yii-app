<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
<div>Изменить статус заказа</div>
        <?= Html::a('New', ['change-status', 'id' => $model->id, 'status' => $model::NEW_ORDER], [
            'class' => 'btn btn-default',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a('New', ['change-status', 'id' => $model->id, 'status' => $model::PROCESSED_ORDER], [
            'class' => 'btn btn-default',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a('New', ['change-status', 'id' => $model->id, 'status' => $model::REVOKED_ORDER], [
            'class' => 'btn btn-default',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a('New', ['change-status', 'id' => $model->id, 'status' => $model::DONE_ORDER], [
            'class' => 'btn btn-default',
            'data-toggle' => 'tooltip',
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'surname',
            'country',
            'region',
            'city',
            'address',
            'organization_name',
            'post_index',
            'phone',
            'email:email',
            'delivery_date:date',
            'coupon_id',
            [
                'attribute' => 'status_id',
                'value' => $model::getStatus()[$model->status_id]
            ],
            'created_at:datetime',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
//                'value' => function($data){
//                    return $data->product->name;
//                },
            ],
//            [
//                'attribute' => 'color_id',
//                'value' => function($data){
//                    return $data->color->name;
//                },
//            ],
//            [
//                'attribute' => 'size_id',
//                'value' => function($data){
//                    return $data->size->value;
//                },
//            ],
            [
                'attribute' => 'quantity',
//                'format' => 'currency',
//                'value' => function($data){
//                    $product = $data->product;
//                    return $product->discount_price ? $product->discount_price : $product->price;
//                },
                'footer' => 'Итого:'
            ],
            [
                'attribute' => 'price',
                'format' => 'currency',
//                'value' => function($data){
//                    $product = $data->product;
//                    return $product->discount_price ? $product->discount_price : $product->price;
//                },
                'footer' => 'Итого:'
            ],
//            'amount',
//            [
//                'attribute' => 'total',
//                'format' => 'currency',
//                'value' => function($data){
//                    return $data->total;
//                },
//                'footer' => 0
//            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
   ]);
    ?>

</div>
