<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Size */

$this->title = 'Создание размера';
$this->params['breadcrumbs'][] = ['label' => 'Размеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="size-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
