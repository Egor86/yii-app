<?php

use common\models\Category;
use common\models\Product;
use kotchuprik\sortable\grid\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
            [
                'class' => Column::className(),
            ],
            [
                'attribute' => 'id',
                'format' => 'html',
                'filter'=> false,
                'options' => [
                    'width' => '15px'
                ]
            ],
            [
                'attribute' => 'name',
                'format' => 'html',
                'options' => [
                    'width' => '300px'
                ]
            ],
//            'brand.name',
            [
                'attribute' => 'video_id',
                'format' => 'html',
                'value' => function($data){
                    return $data->video ? $data->video->file_name : null;
                },
//                'filter'=> false,
                'options' => [
                    'width' => '250px'
                ]
            ],
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category ? $data->category->name : null;
                },
                'format' => 'html',
                'filter'=> ArrayHelper::map(Category::find()->all(), 'id', 'name'),
            ],
            // 'created_at',
            // 'updated_at',
            [
                'attribute' => 'published',
                'value' => function($data){
                    $list = Product::publishedList();
                    return $list[$data->published];
                },
                'filter'=> Product::publishedList(),
                'options' => [
                    'width' => '15px'
                ]
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
