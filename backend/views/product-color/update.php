<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */
/* @var $product common\models\Product */
/* @var $product_color_size common\models\ProductColorSize */

$this->title = 'Update Product Color: ' . $product->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-color-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product' => $product,
        'product_color_size' => $product_color_size
    ]) ?>

</div>
