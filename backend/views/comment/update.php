<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Обновление комментария #: ' . $model->id . ', к продукту #' . $model->item->id . ' - ' . $model->item->name;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
