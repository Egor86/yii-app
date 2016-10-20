<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

/** @var array $product common\models\Product*/
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>count <?= Yii::$app->cart->count;?></h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php for ($i =0; $i < count($product); $i++) :?>
            <div class="col-lg-4">
                <h2><?=$product[$i]->name;?></h2>

                <p><?=$product[$i]->price;?></p>

                <p><a class="btn btn-default" href="<?= Url::to('/cart/create.html?product_id='.$product[$i]->id);?>"><?=$product[$i]->id;?></a></p>
                <p><a class="btn btn-default" href="<?= Url::to('/product/view.html?id='.$product[$i]->id);?>">View</a></p>
            </div>
            <?php endfor;?>

            <div class="col-lg-4">

                <p><a class="btn btn-default" href="<?= Url::to('/cart/view.html');?>">Перейти в корзину</a></p>
            </div>
        </div>

    </div>
</div>
