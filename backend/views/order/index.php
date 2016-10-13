<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
    //            ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'surname',
    //            'country',
    //            'region',
                 'city',
                 'address',
                // 'organization_name',
    //             'post_index',
                 'phone',
                // 'email:email',
                 'delivery_date:date',
                [
                    'attribute' => 'coupon_id',
                    'value' => function($data){
                        return $data->coupon ? $data->coupon->coupon_code : null;
                    },
                ],
                [
                    'attribute' => 'status_id',
                    'value' => function($data){
                        return $data::getStatus()[$data->status_id];
                    },
                ],
                 'created_at:datetime',
    //             'updated_at:datetime',
                // 'sort_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
