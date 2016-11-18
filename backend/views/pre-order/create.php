<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PreOrder */

$this->title = 'Create Pre Order';
$this->params['breadcrumbs'][] = ['label' => 'Pre Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
