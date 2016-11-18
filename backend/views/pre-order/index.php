<?php

use common\models\Item;
use common\models\PreOrder;
use common\models\Size;
use common\models\Subscriber;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PreOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пред-заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-order-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'phone',
            'email',
            [
                'attribute' => 'item_id',
                'value' => function ($model) {
                    return $model->item->stock_keeping_unit . ' / ' . $model->item->name;
                },
                'filter' => ArrayHelper::map(
                    Item::find()
                        ->where(['in', 'id',
                            PreOrder::find()
                                ->select(['item_id'])
                                ->asArray()
                                ->column()])
                        ->all(), 'id', 'stock_keeping_unit')
            ],
            [
                'attribute' => 'size_id',
                'value' => function ($model) {
                    return $model->size->value;
                },
                'filter' => ArrayHelper::map(
                    Size::find()
                        ->where(['in', 'id',
                            PreOrder::find()
                                ->select(['size_id'])
                                ->asArray()
                                ->column()])
                        ->all(), 'id', 'value')
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => false
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create-order} {delete}',
                'buttons' => [
                    'create-order' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-share"></span>', 'create-order?id='.$model->id, [
                            'title' => 'Создать заказ',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
