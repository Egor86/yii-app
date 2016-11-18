<?php

/* @var $this yii\web\View */

use common\models\Comment;
use common\models\Coupon;
use common\models\Order;
use common\models\Subscriber;

$date = new DateTime(date("Y-m-d"));
$today = $date->getTimestamp();
$yesterday = $date->add(DateInterval::createFromDateString('yesterday'))->getTimestamp();

$this->title = 'Панель управления администратора';
?>
<div class="site-index">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Количество заказов:</span>
                <span class="info-box-number">Новых: <?= Order::find()->where(['status' => Order::ORDER_NEW])->count()?></span>
                <span class="info-box-number">Быстрых: <?= Order::find()->where(['status' => Order::ORDER_FAST])->count()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Количество новых подписчиков</span>
                <span class="info-box-number">Сегодня: <?= Subscriber::find()->where(['>' ,'created_at', $today])->count()?></span>
                <span class="info-box-number">Вчера: <?= Subscriber::find()
                        ->where(['<' ,'created_at', $today])->andWhere(['>', 'created_at', $yesterday])->count()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-comment"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Количество новых комментариев</span>
                <span class="info-box-number">Сегодня:  <?= Comment::find()->where(['>' ,'created_at', $today])->count()?></span>
                <span class="info-box-number">Вчера: <?= Comment::find()->where(['<' ,'created_at', $today])->andWhere(['>', 'created_at', $yesterday])->count()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-tag"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Купоны</span>
                <span class="info-box-number">USED: <?= Coupon::find()->where(['using_status'=> Coupon::USED])->count()?></span>
                <span class="info-box-number">UNUSED: <?= Coupon::find()->where(['using_status'=> Coupon::UNUSED])->count()?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
</div>
