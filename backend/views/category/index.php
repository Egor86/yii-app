<?php

use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
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
//            'id',
            'name',
            'description:ntext',
            [
                'attribute' => 'parent',
                'value' => function($data){
                    return $data->parent ? Category::findOne($data->parent)->name : 'родитель';
                },
                'format' => 'html',
                'filter'=> Category::getParentsList(),
            ],
//            'parent',
            'slug',
            [
                'attribute' => 'size_table_name_id',
                'value' => function($data){
                    return $data->sizeTableName->name;
                },
                'format' => 'html',
                'filter'=> ArrayHelper::map(\common\models\SizeTableName::find()->all(), 'id', 'name'),
            ],
//            'size_table_name_id',
            // 'created_at',
            // 'updated_at',
            // 'sort_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
