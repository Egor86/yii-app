<?php

use common\helpers\Image;
use common\models\Color;
use common\models\ImageStorage;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Color */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$img = ImageStorage::findOne(['class' => get_class($model),'class_item_id' => $model->id])

?>
<div class="color-view">


    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'rgb_code',
                'format' => 'html',
                'value' => $model->type == Color::COLOR_RGB ?
                    "<span class='badge' style='background-color: {$model->rgb_code}'> </span> " . $model->rgb_code :
                    ($img ?
                    Html::img(Image::thumb($img->file_path, Yii::getAlias('@front-web'), 40, 40)) : ''),
            ],
//            'created_at',
//            'updated_at',
//            'sort_by',
        ],
    ]) ?>

</div>
