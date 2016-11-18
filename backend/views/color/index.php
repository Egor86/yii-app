<?php

use common\helpers\Image;
use common\models\Color;
use common\models\ImageStorage;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Цвета';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="color-index">


    <p>
        <?= Html::a('Создать новый цвет', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать кавер фото', ['create-caver'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'attribute' => 'rgb_code',
                'format' => 'html',
                'value' => function($model) {
                    if ($model->type == Color::COLOR_RGB) {
                        return "<span class='badge' style='background-color: {$model->rgb_code}'> </span> " . $model->rgb_code;
                    }
                    $img = ImageStorage::findOne(['class' => get_class($model),'class_item_id' => $model->id]);

                    if ($img) {
                        return Html::img(Image::thumb($img->file_path, Yii::getAlias('@front-web'), 40, 40));
                    }
                    return '';
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            // 'sort_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
