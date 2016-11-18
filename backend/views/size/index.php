<?php

use common\models\SizeTableName;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\search\SizeSearch */


$this->title = 'Размеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="size-index">


    <p>
        <?= Html::a('Создать размер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'value',
            [
                'attribute' => 'size_table_name_id',
                'value' => function($model) {
                    return $model->sizeTableName->name;
                },
                'filter' => ArrayHelper::map(SizeTableName::find()->all(), 'id', 'name')
            ],


            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
