<?php

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'parent')
        ->dropDownList(ArrayHelper::map(\common\models\Category::find()
        ->where(['not', ['id' => $model->id]])
        ->andWhere(['not', ['parent' => $model->id]])
        ->all(), 'id', 'name'), ['prompt' => '-']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size_table_name_id')
        ->dropDownList(ArrayHelper::map(\common\models\SizeTableName::find()
        ->all(), 'id', 'name'), $model->size_table_name_id ?
            ['options' => [$model->size_table_name_id => ['selected' => 'selected']]] :
            ['options' => [2 => ['selected' => 'selected']]]) ?>

    <?= SeoForm::widget(['model' => $model]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
