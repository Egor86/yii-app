<?php

use common\models\Subscriber;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
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
        'resizableColumns' => false,
        'showPageSummary' => false,
        'pjax' => true,
        'striped' => true,
        'hover' => false,
        'panel'=>['type'=>'primary', 'heading' => 'Подписчики'],
        'exportConfig' => [
            GridView::EXCEL => ['label' => 'Excel',
                'icon' => 'file-excel-o',
                'iconOptions' => ['class' => 'text-success'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => 'subscribers',
                'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
                    'cssFile' => ''
                ]],
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'filter'=> false,
                'options' => [
                    'width' => '15px'
                ],
                'mergeHeader' => true
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
                'class' => '\kartik\grid\ActionColumn',
                'template'=>'{view} {update}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
