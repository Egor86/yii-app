<?php

use common\models\Coupon;
use common\models\Subscriber;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SubscriberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subscribers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('Create Subscriber', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => \kotchuprik\sortable\grid\Column::className(),
            ],
            'id',
//            'name',
            'email:email',
            'phone',
            [
                'attribute' => 'coupon',
                'value' => function ($data) {
                    return $data->coupons ? $data->coupons[0]->coupon_code : '--';
                },
            ],
            [
                'attribute' => 'couponUsingStatus',
                'value' => function ($data) {
                    return $data->coupons ? $data->coupons[0]->using_status ? 'Да' : 'Нет' : '--';
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'mail_chimp_status',
                'value' => function($data){
                    $list = Subscriber::getMailChimpStatus();
                    return $list[$data->mail_chimp_status];
                },
                'filter'=> Subscriber::getMailChimpStatus(),
            ],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
