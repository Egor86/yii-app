<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PreOrder */

$this->title = 'Update Pre Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pre Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pre-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
