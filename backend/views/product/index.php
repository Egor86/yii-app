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
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
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
            'id',
            'name',
            [
                'attribute' => 'brand_id',
                'value' => function($data){
                    return $data->brand ? $data->brand->name : null;
                },
                'format' => 'html',
                'filter'=> ArrayHelper::map(\common\models\Brand::find()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category ? $data->category->name : null;
                },
                'format' => 'html',
                'filter'=> ArrayHelper::map(Category::find()->all(), 'id', 'name'),
            ],
            [
                 'attribute' => 'published',
                 'value' => function($data){
                     $list = Product::publishedList();
                     return $list[$data->published];
                 },
                 'filter'=> Product::publishedList(),
             ],
                [
                'class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'add'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/product-color/update','product_id'=>$model->id]);
                            return Html::a( '<span class="glyphicon glyphicon-cloud-upload"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Добавить цвета и размеры'), 'data-pjax' => '0']);
                }
                ],
                'template'=>'{view} {update} {delete} {add}',
            ],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
