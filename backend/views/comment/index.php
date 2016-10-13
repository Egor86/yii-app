<?php

use common\models\Comment;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => \kotchuprik\sortable\grid\Column::className(),
            ],
            [
                'attribute' => 'product_id',
                'value' => function($data){
                    return $data->product->name;
                },
                'filter'=> ArrayHelper::map(Product::find()->all(), 'id', 'name'),
            ],
            'text:ntext',
            [
                'attribute' => 'user_name',
                'filter'=> ArrayHelper::map(Comment::find()->all(), 'user_name', 'user_name'),
            ],
            [
                'attribute' => 'agree',
                'value' => function($data){
                    return Comment::getStatus()[$data->agree];
                },
                'filter'=> Comment::getStatus(),
            ],
            [
                'attribute' => 'favorite',
                'value' => function($data){
                    return Comment::getStatus()[$data->favorite];
                },
                'filter'=> Comment::getStatus(),
            ],
             'created_at:datetime',

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
