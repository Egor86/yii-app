<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Color */

$this->title = 'Создать новый цвет';
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
