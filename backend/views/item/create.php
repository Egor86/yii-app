<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $product common\models\Product */
/** @var $item_sizes common\models\ItemSize */
/* @var $multiple_forms backend\models\MultipleImageForm */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product' => $product,
        'item_sizes' => $item_sizes,
        'image_storages' => $image_storages
    ]) ?>

</div>
