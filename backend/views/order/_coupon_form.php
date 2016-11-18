<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $coupon_form common\models\CouponForm */
/* @var $model common\models\Order */

$this->registerJs('
$(".coupon").click(function(event){ // нажатие на кнопку - выпадает модальное окно
        event.preventDefault();
      
        var clickedbtn = $(this);         
        var modalContainer = $("#my-modal");
        var modalBody = modalContainer.find(".modal-body");
        modalContainer.modal({show:true});
  
    });
    
$(".check").click("submit", function(event){ 
        event.preventDefault();
        var form = $(".coupon-form");
        $.ajax({
            url: "/admin/coupon/check",
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
<p><a class="btn btn-danger coupon">Добавить купон</a></p>
    <!-- Modal -->
    <div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="form-group has-error"><div id="result" class="help-block"></div></div> <!-- For error message -->

                    <div class="gb-user-form">

                        <?php $form = ActiveForm::begin(['action' => null, 'options' => ['class' => 'coupon-form']]); ?>

                        <?= $form->field($coupon_form, 'email')->textInput(['value' => $model->email]) ?>

                        <?= $form->field($coupon_form, 'phone')->textInput(['value' => $model->phone, ]) ?>

                        <?= $form->field($coupon_form, 'coupon_code') ?>

                        <?= $form->field($coupon_form, 'order_id')->hiddenInput(['value' => $model->id])->label(false)?>

                        <div class="form-group text-right">
                            <?= Html::submitButton('Проверить', ['class' => 'btn btn-success btn-update-password check']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
               </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div><!-- /.modal -->