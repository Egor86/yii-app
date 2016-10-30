<?php

/* @var $this yii\web\View */
/** @var $coupon_form frontend\models\CouponForm */

?>

<div class="success">Вам предоставлена скидка <?= Yii::$app->formatter->asCurrency($coupon_form->coupon->discount)?></div>
<script>
    (function(){
        $("#discount").text('- <?=Yii::$app->formatter->asCurrency($coupon_form->coupon->discount)?>');
        $("#total-pay").text('<?=Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost(true))?>');
    })();
</script>