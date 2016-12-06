<?php

use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */



?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js page-not-found"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Страница не найдена</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/normalize.min.css">
    <link rel="stylesheet" href="/css/libs.css">
    <link rel="stylesheet" href="/css/main.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"><!-- Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans+Narrow" rel="stylesheet">

    <script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body class="page-not-exist">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<section class="page404">
    <div class="logo404">
        <img src="/data/img/logo.png" alt=""><span class="slogan">Надеваешь ты –<br> снимает она!</span>
    </div>
    <h1><strong>УВЫ,</strong> такой страницы не существует.</h1>
    <div class="element-person"><img src="/data/img/photo404.png" alt=""></div>
    <p class="text404">404</p>

    <div class="subscribe" style="background-image: url(/data/img/image4.jpg)">
        <h4>ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ</h4>
        <p>300 ГРН НА ЛЮБОЙ ЗАКАЗ</p>
        <div class="signup-form">
            <form action="<?= Url::to(['subscriber/create'])?>" method="post">
                <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                <input type="text" name="Subscriber[name]" placeholder="Введите ваше имя" required>
                <input type="email" class="email" name="Subscriber[email]" placeholder="E-mail" required>
                <input type="text" name="Subscriber[phone]" placeholder="Номер мобильного" required>
                <input type="submit" class="send" value="ПОДПИСАТЬСЯ">
            </form>
            <strong>Мы не занимаемся рассылкой спама</strong>
        </div>          <!-- signup-form -->
    </div>              <!-- subscribe -->
    <a class="goto-main" href="<?= Yii::$app->getHomeUrl()?>">ПЕРЕЙТИ НА ГЛАВНУЮ</a>

    <div class="represent-brend">
        <div class="represent-brend-item" style="background-image: url(/data/img/shape1.svg)">
            <strong>ИНДИВИДУАЛЬНЫЙ ПОШИВ</strong>
        </div>
        <div class="represent-brend-item" style="background-image: url(/data/img/shape2.svg)">
            <strong>100% НАТУРАЛЬНЫЕ МАТЕРИАЛЫ</strong>
        </div>
        <div class="represent-brend-item" style="background-image: url(/data/img/shape3.svg)">
            <strong>ОПРАВДАННАЯ ЦЕНА</strong>
        </div>
    </div>

</section>

<!-- <h4>ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ</h4>
    <p>150 ГРН НА ПОКУПКУ</p>
    <span class="get-gift">+ ГАРАНТИРОВАННО ЦЕННЫЙ ПОДАРОК</span> -->

<!-- <div class="signup-form">
    <form action="" method="post">
        <span class="helper">Введи своё имя</span>
        <input type="text" class="first-name">
        <span class="helper">E-mail</span>
        <input type="email" class="email" required>
        <span class="helper">Номер мобильного</span>
        <input type="text" class="phone-number">
        <input type="submit" class="send" value="ПОДПИСАТЬСЯ">
    </form>
    <strong>Успешные парни принимают решение мгновенно,<br>когда речь заходит о собственной выгоде!</strong>
</div>   -->

<!--  <div class="social-network">
     <a href="https://vk.com/egoist_original"><img src="img/vk-xxl.png" alt=""></a>
     <a href="https://www.facebook.com/egoist.me.ukraine"><img src="img/facebook-icon.png" alt=""></a>
     <a href="https://www.instagram.com/egoist_original/"><img src="img/instagram-icon.png" alt=""></a>
 </div>
-->

<section class="popup-forms">
    <div class="popup-wait-form">
        <div class="wait-form">
            <a href="javascript:;" class="">ОЖИДАЙТЕ, ИДЕТ ОБРАБОТКА ДАННЫХ</a>
        </div><!-- popup-wait-form -->
    </div>          <!-- popup-forms -->

    <div class="popup-notify">
        <div class="popup-wait-form popup-notify">
            <div class="wait-form">
                <a href="javascript:;" class="message-wrap"></a>
            </div><!-- popup-wait-form -->
        </div>      <!-- popup-wait-form popup-notify -->
    </div>              <!-- popup-notify -->

    <div class="popup-success-form">
        <div class="success-form">
            <a href="javascript:;" class=""><strong>БЛАГОДАРЮ!</strong><span>Загляни на почту, я и мои стилисты приготовили для тебя что-то особенное.</span></a>
        </div><!-- popup-wait-form -->
    </div>          <!-- popup-forms -->
</section>



<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
<script src="/js/vendor/jquery.colorbox-min.js"></script>

<script src="/js/vendor/libs.js"></script>
<script src="/js/main.js"></script>
<?php if (Yii::$app->session->hasFlash('message')) :
    $message = Yii::$app->session->getFlash('message');?>
<script>notify('<?=$message?>');</script>
<?php endif;?>
</body>
</html>
