<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Color */

$this->title = 'Создать кавер фото';
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-create">


    <?= $this->render('_form', [
        'model' => $model,
        'imageForm' => $imageForm
    ]) ?>

</div>