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
            <?php for ($i =0; $i < count($item); $i++) :?>
            <div class="col-lg-4">
                <h2><?=$item[$i]->name;?></h2>

                <p><?=$item[$i]->price;?></p>

                <p><a class="btn btn-default" href="<?= Url::to('/cart/create.html?item_id='.$item[$i]->id);?>"><?=$item[$i]->id;?></a></p>
                <p><a class="btn btn-default" href="<?= Url::to('/item/view.html?id='.$item[$i]->id);?>">View</a></p>
            </div>
            <?php endfor;?>

            <div class="col-lg-4">

                <p><a class="btn btn-default" href="<?= Url::to('/cart.html');?>">Перейти в корзину</a></p>
            </div>
        </div>

    </div>
</div>
