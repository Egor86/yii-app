<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = 'Создание новой акции';
$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
