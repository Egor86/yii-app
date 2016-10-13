<?php

use common\models\Color;
use common\models\Size;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить данные', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить фото', ['/product/add-images', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Обновить цвета и размеры', ['/product-color/'.(empty($model->colors) ? 'create' : 'update'), 'product_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:html',
            'brand.name',
            'category.name',
            'stock_keeping_unit',
            'slug',
            'price:currency',
            'discount_price:currency',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'published',
                'value' => \common\models\Product::publishedList()[$model->published]
            ],
            'seo.title',
            'seo.keyword',
            'seo.description',
            [
                'attribute' => 'videoStorage',
                'value' => $model->video ? $model->video->file_name : ''
            ],
        ],
    ]) ?>

</div>

<div class="product-color-size-view">
    <?=GridView::widget([
        'dataProvider'=>$dataProvider,
        'showPageSummary'=>true,
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
        'export' => false,
        'panel'=>['type'=>'primary', 'heading'=>'Цвета, размеры и количество'],
        'columns'=>[
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'attribute'=>'color.name',
                'width'=>'310px',
                'group'=>true,
            ],
            [
                'attribute'=>'size.value',
                'width'=>'250px',
                'pageSummary'=>'Итого:',
                'pageSummaryOptions'=>['class'=>'text-center text-warning'],
            ],
            [
                'attribute'=>'amount',
                'pageSummaryOptions'=>['class'=>'text-left text-warning'],
                'pageSummary'=>true,
                'pageSummaryFunc'=>GridView::F_SUM
            ],
        ],
    ]);?>
</div>

