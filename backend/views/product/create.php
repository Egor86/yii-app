<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $video_form backend\models\VideoForm */

$this->title = 'Создание продукта';
$this->params['breadcrumbs'][] = ['label' => 'Продукта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">


    <?= $this->render('_form', [
        'model' => $model,
        'video_form' => $video_form,
    ]) ?>

</div>
