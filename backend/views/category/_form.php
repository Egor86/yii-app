<?php

use common\models\Category;
use common\models\SizeTableName;
use common\widgets\SeoForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-6">
    <?= $form->field($model, 'parent')
        ->dropDownList(ArrayHelper::map(Category::findAll(['parent' => 0]), 'id', 'name')) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'size_table_name_id')
            ->dropDownList(ArrayHelper::map(SizeTableName::find()
                ->all(), 'id', 'name'), $model->size_table_name_id ?
                ['options' => [$model->size_table_name_id => ['selected' => 'selected']]] :
                ['options' => [2 => ['selected' => 'selected']]]) ?>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= SeoForm::widget(['model' => $model]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
