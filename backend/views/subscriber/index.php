<?php

use common\models\Coupon;
use common\models\Subscriber;
use yii\helpers\ArrayHelper;
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

<?php Pjax::begin(); ?>
    <?= GridView::widget([
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
                    return $data->coupon ? $data->coupon->coupon_code : null;
                },
                'filter'=> ['С купоном', 'Без купона'],
            ],
            [
                'attribute' => 'couponUsingStatus',
                'value' => function ($data) {
                    return $data->coupon ? $data->coupon->using_status ? 'Да' : 'Нет' : null;
                },
                'filter'=> ['Нет', 'Да'],
            ],
            [
                'attribute' => 'mail_chimp_status',
                'value' => function($data){
                    return Subscriber::getMailChimpStatus()[$data->mail_chimp_status];
                },
                'filter'=> ArrayHelper::filter(
                    Subscriber::getMailChimpStatus(),
                    Subscriber::find()
                        ->select('mail_chimp_status')
                        ->column()
                ),
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
