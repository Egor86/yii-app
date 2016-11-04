<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Комментарий #' . $model->id . ' к продукту #' . $model->item->id . ' - ' . $model->item->name;;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

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
            [
                'attribute' => 'item.name',
                'label' => 'Комментарий к товару'
            ],
            'text:ntext',
            [
                'attribute' => 'agree',
                'format' => 'boolean'
            ],
            [
                'attribute' => 'favorite',
                'format' => 'boolean'
            ],
            'user_name',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
