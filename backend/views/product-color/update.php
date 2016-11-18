<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */

$this->title = 'Update Product Color: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
