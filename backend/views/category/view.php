<?php

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'name',
            'description:ntext',
            [
                'attribute' => 'parent',
                'value' => $model->parent ? Category::findOne($model->parent)->name : 'родитель',
            ],
            'slug',
            [
                'attribute' => 'size_table_name_id',
                'value' => \common\models\SizeTableName::findOne($model->size_table_name_id)->name,
            ],
            'created_at:datetime',
            'updated_at:datetime','seo.title',
            'seo.keyword',
            'seo.description'
        ],
    ]) ?>

</div>
