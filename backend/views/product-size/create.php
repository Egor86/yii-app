<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductSize */

$this->title = 'Create Product Size';
$this->params['breadcrumbs'][] = ['label' => 'Product Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
