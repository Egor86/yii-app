<?php

use common\models\Color;
use common\models\Product;
use common\models\Item;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ItemSearch */
/* @var $data Provider yii\data\ActiveDataProvider */
/* @var $model common\models\Item */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'product_id',
                'value' => function($model) {
                    return $model->product->name;
                },
                'filter' => ArrayHelper::map(Product::find()->where(['in', 'id', Item::find()->select('product_id')->column()])->all(), 'id', 'name')
            ],
            [
                'attribute' => 'color_id',
                'value' => function($model) {
                    return $model->color->name;
                },
                'filter' => ArrayHelper::map(Color::find()->where(['in', 'id', Item::find()->select('color_id')->column()])->all(), 'id', 'name')
            ],
             'stock_keeping_unit',
             'price',
             'discount_price',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
