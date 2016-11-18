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

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">


<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
            [
                'class' => \kotchuprik\sortable\grid\Column::className(),
            ],
            [
                'attribute' => 'item_id',
                'value' => function($data){
                    return $data->item->name;
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
                'filter'=> ['Нет', 'Да'],
                'format' => 'boolean'
            ],
            [
                'attribute' => 'favorite',
                'filter'=> ['Нет', 'Да'],
                'format' => 'boolean'
            ],
            [
                'attribute' => 'created_at',
                'filter'=> false,
                'format' => 'datetime'
            ],
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
