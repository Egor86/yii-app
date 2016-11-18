<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PasswordForm */
/* @var $form ActiveForm */

$this->title = 'Замена пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(
    [
        'fieldConfig' => [
            'template' => "<div class=\"row\"><div class=\"col-sm-6\"{label}\n{input}\n{hint}\n{error}</div></div>",
        ]
    ]
); ?>
<?= $form->field($model, 'oldpassword')->passwordInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'repassword')->passwordInput() ?>
    <div class="row">
        <div class="col-sm-6">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>