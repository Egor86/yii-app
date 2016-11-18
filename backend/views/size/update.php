<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Size */

$this->title = 'Обновление размеры: ' . $model->value;
$this->params['breadcrumbs'][] = ['label' => 'Размеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="size-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
