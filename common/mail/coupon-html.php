<?php

/* @var $this \yii\web\View view component instance */
use yii\helpers\Html;

$this->title = $title;
?>
<div class="coupon">
    <p>Привет, друг!</p>
	<p><b>Добро пожаловать в мир Эгоистов!</b></p>
	<p>Как и обещал, вот твой Купон на скидку 150 грн,</p>
    <p>который ты можешь использовать в любое время и на любую вещь.</p>

    <p>Код купона: <b><?= $body?></b></p>

    <p><b>И уже в следующем письме Я немного приоткрою тебе занавес,<b></p> 
	<p>и расскажу как сделать так,</p>
    <p>чтобы тебя приглашали на телевидение, о тебе писали в журналах, и появилось фанаты,</p>
    <p>которые равняются на тебя, как сделать из своего имени настоящий Бренд...</p>

    <p><b>А пока, если ты еще не с нами, давай дружить и в соц сетях:<b></p>
    <p>Вк: <?= Html::a('https://vk.com/egoist_original', 'https://vk.com/egoist_original')?></p>
    <p>Фб: <?= Html::a('https://www.facebook.com/egoist.me.ukraine', 'https://www.facebook.com/egoist.me.ukraine')?></p>
    <p>Инста: <?= Html::a('https://www.instagram.com/egoist_original/', 'https://www.instagram.com/egoist_original/')?></p>

    <p><b>До связи.<b></p>
    <p>Твой новый друг Egoist)</p>
</div>
