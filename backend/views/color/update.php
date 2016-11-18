<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Color */

$this->title = 'Обновить цвет: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="color-update">


    <?= $this->render('_form', [
        'model' => $model,
        'imageForm' => $imageForm
    ]) ?>

</div>
