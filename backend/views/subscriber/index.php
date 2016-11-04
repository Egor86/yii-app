<?php

use common\models\Coupon;
use common\models\Subscriber;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SubscriberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подписчики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            [
                'attribute' => 'id',
                'format' => 'html',
                'filter'=> false,
                'options' => [
                    'width' => '15px'
                ]
            ],
            'name',
            'email',
            'phone',
            [
                'attribute' => 'coupon',
                'value' => function ($data) {
                    return $data->coupons ? $data->coupons[0]->coupon_code : null;
                },
            ],
            [
                'attribute' => 'couponUsingStatus',
                'value' => function ($data) {
                    return $data->coupons ? $data->coupons[0]->using_status ? 'Да' : 'Нет' : null;
                },
            ],
            [
                'attribute' => 'mail_chimp_status',
                'value' => function($data){
                    $list = Subscriber::getMailChimpStatus();
                    return $list[$data->mail_chimp_status];
                },
                'filter'=> Subscriber::getMailChimpStatus(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}',
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
