<?php

/* @var $this yii\web\View */
use common\models\Item;
use yii\helpers\Url;

/** @var array $product common\models\Product*/
$this->title = Yii::$app->name;

$this->registerJs('
$(document).ready(function(){
   $("#imgLoad").hide();  //Скрываем прелоадер
});
var offset = '. Item::ITEM_VIEW_LIMIT .'; //чтобы знать с какой записи вытаскивать данные
$(function() {
   $("#more").click(function(){ //Выполняем если по кнопке кликнули
   $.ajax({
          url: "site/more.html",
          dataType: "html",
          type: "post",
          data: {offset: offset},
          cache: false,
          success: function(response){
              if(!response){  // смотрим ответ от сервера и выполняем соответствующее действие
                 alert("Больше нет записей");
              }else{
                 $(".body-content").append(response);
                 offset = offset + '. Item::ITEM_VIEW_LIMIT .';
              }
           }
        });
    });
});
', \yii\web\View::POS_END)
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>count <?= Yii::$app->cart->count;?></h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">

            <?= $this->render('item', ['item' => $item]) ?>

            <div class="col-lg-4">

                <p><a class="btn btn-default" href="<?= Url::to('/cart.html');?>">Перейти в корзину</a></p>
            </div>
        </div>
        <div id="more"><?= \yii\helpers\Html::button('Загрузить еще', ['class' => 'btn btn-primary'])?></div>
    </div>
    <?= \yii\helpers\Html::a('Category', ['category/view', 'slug' => 'woman-wear'])?>
</div>
