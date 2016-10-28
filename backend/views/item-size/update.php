<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models common\models\ItemSize */
/* @var $item common\models\Item */

//$this->title = 'Update Item Size: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Item Sizes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-size-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'models' => $models,
        'item' => $item,
    ]) ?>

</div>
