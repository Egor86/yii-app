<?php

/* @var $this yii\web\View */
/** @var $coupon_form frontend\models\CouponForm */

?>

<div class="success">Вам предоставлена скидка <?= Yii::$app->formatter->asCurrency($coupon_form->coupon->discount)?></div>
<script>
    (function(){
        $("#coupon-id").val('<?=$coupon_form->coupon->id?>');
        $("#discount").text('- <?=Yii::$app->formatter->asCurrency($coupon_form->coupon->discount)?>');
        $("#total-sum").text('<?=Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost(true))?>');
    })();
</script>