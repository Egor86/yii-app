<?php

use common\models\Campaign;
use kartik\grid\BooleanColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Campaign */

$this->title = 'Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
    <h4><a class="dashed-link collapsed" data-toggle="collapse" href="#create-campaign" aria-expanded="false" aria-controls="create-campaign">Создать новую акцию</a></h4>
    </p>
    <div class="collapse" id="create-campaign">
        <?= $this->render('_form', ['model' => $model])?>
    </div>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizableColumns' => false,
        'export' => false,
        'columns' => [
            'id',
            'name',
            'discount:currency',
            [
                'attribute' => 'coupon_action_time',
                'value' => function ($data) {
                    $data1 = new DateTime(date("Y-m-d H:i", $data->coupon_action_time));
                    $data2 = new DateTime(date("Y-m-d H:i", 0));
                    $interval = $data1->diff($data2);
                    return $interval->format('Дни: %d, часы: %h, минуты: %i');
                },
            ],
            [
                'class' => BooleanColumn::className(),
                'attribute' => 'status',
                'trueIcon' => '<span class="label label-success">'. Campaign::getStatus()[1] . '</span>',
                'falseIcon' => '<span class="label label-danger">' . Campaign::getStatus()[0] . '</span>',
                'width' => '150px'
            ],
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
