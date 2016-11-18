<?php

use common\models\PreOrder;
use common\models\Subscriber;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $item common\models\Item */
/* @var array $unavailable_sizes */
$pre_order = new PreOrder();

?>
<p><a class="btn btn-danger pre-order">Сообщить о наличии</a></p>
<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="form-group has-error"><div id="result" class="help-block"></div></div> <!-- For error message -->

                <div class="gb-user-form">

                    <?php $form = ActiveForm::begin(['action' => null, 'options' => ['class' => 'pre-order-form']]); ?>

                    <?= $form->field($pre_order, 'name')->textInput()?>

                    <?= $form->field($pre_order, 'email')->textInput()?>

                    <?= $form->field($pre_order, 'phone')->textInput()?>

                    <?= $form->field($pre_order, 'item_id')->hiddenInput(['value' => $item->id])->label(false) ?>

                    <?= $form->field($pre_order, 'size_id')->radioList($unavailable_sizes) ?>

                    <div class="form-group text-right">
                        <?= Html::submitButton('Проверить', ['class' => 'btn btn-success btn-update-password send']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->