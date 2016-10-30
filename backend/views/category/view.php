<?php

use common\models\Category;
use common\models\SizeTableName;
use common\widgets\SeoForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'formOptions' => [
            'action' => Url::to('update?id='.$model->id),
        ],
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'# ' . $model->id.' '.$model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
//            'id',
            'name',
            [
                'attribute' => 'description',
                'type'=>DetailView::INPUT_TEXTAREA,
            ],
            [
                'attribute' => 'parent',
                'value' => $model->parent ? Category::findOne($model->parent)->name : 'родитель',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'parent')
                        ->dropDownList(ArrayHelper::map(Category::find()
                            ->where(['not', ['id' => $model->id]])
                            ->andWhere(['not', ['parent' => $model->id]])
                            ->all(), 'id', 'name'), ['prompt' => '-']);
                }
            ],
            'slug',
            [
                'attribute' => 'size_table_name_id',
                'value' => SizeTableName::findOne($model->size_table_name_id)->name,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'size_table_name_id')
                        ->dropDownList(ArrayHelper::map(SizeTableName::find()
                            ->all(), 'id', 'name'));
                }
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'created_at',
                        'displayOnly' => true,
                        'format' => 'datetime',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'displayOnly' => true,
                        'format' => 'datetime',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                ],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],[
                'group'=>true,
                'label'=>'Seo параметры',
                'rowOptions'=>['class'=>'info'],
                'groupOptions'=>['class'=>'text-center']
            ],
            [
                'columns' => [
                    [
                        'label' => 'Seo title',
                        'value' => $model->seo ? $model->seo->title : '',
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'label' => 'Seo keyword',
                        'value' => $model->seo ? $model->seo->keyword : '',
                        'inputContainer' => ['class'=>'col-sm-6'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'Seo',
                'label' => 'Seo description',
                'value' => $model->seo ? $model->seo->description : '',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return SeoForm::widget(['model' => $model]);
                },
                'labelColOptions' => ['class'=>'kv-edit-hidden', 'style' => 'float: right'],
            ],
        ],
        'deleteOptions' => [
            'url' => 'delete',
            'params' => ['id' => $model->id]],
    ]) ?>

</div>
