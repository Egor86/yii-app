<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */

$this->title = 'Create Product Color';
$this->params['breadcrumbs'][] = ['label' => 'Product Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-color-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
