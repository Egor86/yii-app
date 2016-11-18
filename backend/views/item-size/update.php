<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models common\models\ItemSize */
/* @var $item common\models\Item */

$this->title = 'Размеры и их количество: ' . $item->name;
//$this->params['breadcrumbs'][] = ['label' => 'Item Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $item->name, 'url' => ['item/view', 'id' => $item->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="item-size-update">

    <?= $this->render('_form', [
        'models' => $models,
        'item' => $item,
    ]) ?>

</div>
