<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Subscriber */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->registerJs('

    $("#submit").click("submit", function(event){
        event.preventDefault();
        var form = $("#subscribe");
        $.ajax({
            url: "/subscriber/create.html",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                console.log(data);
                if (data.success) {
                    $("#result").html(data.message);                  
                } else {
                    $("#result").html(data.errors);                      
                }
            }
        })
    })
', \yii\web\View::POS_END);
$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
<div id="result"></div>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
//                'action' => '/subscriber/create.html',
                'id' => 'subscribe']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'phone') ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'submit', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <?php if(isset($errors)){ print_r($errors);}?>
    </div>

</div>
