<?php

use common\models\Order;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form ActiveForm */

$this->registerJs('$(".check").click("submit", function(event){
    event.preventDefault();
    var form = $(".fast-order");
    $.ajax({
            url: "/order/fast-create.html",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
            if(data.success) {
                location.reload();
            } else {
                $("#result").text(data.error);
            }
    }
        });
    });
', \yii\web\View::POS_END)
?>
<div class="order-fast-create">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'fast-order']]); ?>

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'phone') ?>
            <?= $form->field($model, 'status')->input('hidden', ['value' => Order::ORDER_FAST])->label(false) ?>
<!--            --><?//= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
//                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
//            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary check']) ?>
            </div>
        <?php ActiveForm::end(); ?>

</div><!-- order-fast-create -->
