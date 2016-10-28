<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ItemSize */

$this->title = 'Create Item Size';
$this->params['breadcrumbs'][] = ['label' => 'Item Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
