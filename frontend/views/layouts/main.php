<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\Image;
use common\models\Category;
use common\models\Color;
use common\models\ImageStorage;
use common\models\Page;
use common\models\Size;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?= Html::encode(isset($this->params['seo']) ? $this->params['seo']->title : $this->title) ?></title>
    <meta name="description" content="<?= isset($this->params['seo']) ? $this->params['seo']->description : '' ?>">
    <meta name="keywords" content="<?= isset($this->params['seo']) ? $this->params['seo']->keyword : '' ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?= $this->registerLinkTag([
        'rel' => 'canonical',
        'href' =>
            isset($this->params['canonical']) &&
            $this->params['canonical'] ?
                Url::to($this->params['canonical'], true) :
                Url::canonical()
    ])?>
    <link rel="stylesheet" href="/css/normalize.min.css">
    <link rel="stylesheet" href="/css/libs.css">
    <link rel="stylesheet" href="/css/main.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow&amp;subset=cyrillic" rel="stylesheet">
    <link rel="shortcut icon" href="/data/img/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
    <script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<?php $this->beginBody() ?>
<?php
if (Yii::$app->session->hasFlash('message')) {
    $message = Yii::$app->session->getFlash('message');
    if ($message === true) {
        $this->registerJs('
            function popupSuccess() {
                $.colorbox({
                  inline: true,
                  href: \'.popup-success-form\',      
                  transition: \'none\',
                  onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
                });
            };
            popupSuccess()', View::POS_END);
    } else {
        $this->registerJs("notify('$message')", View::POS_END);
    }
}
?>
<?= $this->render('metriks')?>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<header class="header-mobile">
    <div class="header-mobile-left">
        <div class="mobile-phone-select-parent">
            <div class="phone-select">
                <div class="phone-select-btn">
                    <img src="/data/img/ph-icon.png" alt="" class="handset-icon">
                    <img src="/data/img/ph-icon-act.png" alt="" class="handset-icon handset-icon-active">
                    <a href="tel:+380731032086" class="main-number"><strong>+38 (073) 103-20-86</strong></a>
                    <a href="javascript:;" class="phone-select-icon"><img src="/data/img/tick.svg" alt=""></a>
                </div>
                <ul class="phone-select-dropdown">
                    <li>
                        <img src="/data/img/ph-oper1.svg" alt="">
                        <a href="tel:+380961032086">+38 <strong>(096) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper2.svg" alt="">
                        <a href="tel:+380961032086">+38 <strong>(050) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper3.png" alt="">
                        <a href="tel:+380501032086">+38 <strong>(050) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper4.png" alt="">
                        <a href="tel:+380961032086">+38 <strong>(096) 103-20-86</strong></a>
                    </li>
                </ul>
            </div><!-- .phone-select -->
        </div>
    </div>
    <div class="header-mobile-right">
        <a href="javascript:;" class="mobile-menu-btn"><img src="/data/img/mobile-menu-btn.svg" alt=""></a>
    </div>
</header>

<header class="header-desktop">
    <div class="header-left">
        <a href="<?= Yii::$app->getHomeUrl()?>" class="logo"><img src="/data/img/logo.png" alt=""></a>
        <span class="slogan">Надеваешь ты –<br>снимает она!</span>
        <nav class="scroll-nav">
            <ul>
                <li class="catalog-parent">
                    <a href="javascript:;" class="catalog">КАТАЛОГ</a>
                    <a href="javascript:;" class="catalog-icon"><img src="/data/img/tick.svg" alt=""></a>
                    <div class="dropdown-catalog">
                        <?php $catalog_man = Category::findOne(1);?>
                        <div class="dropdown-catalog-man">
                            <a href="<?= Url::to(['category/view', 'slug' => $catalog_man->slug])?>" class="title"><span>МУЖСКАЯ ОДЕЖДА</span></a>
                                <?php $children_man = Category::findAll(['parent' => $catalog_man->id])?>
                                <?php foreach ($children_man as $child) :?>
                                    <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="dropdown-catalog-section"><span><?= $child->name?></span></a>
                                <?php endforeach;?>

                        </div>
                        <?php if (1==0) :?>
                        <div class="dropdown-catalog-woman">
                            <?php $catalog_woman = Category::findOne(2);?>
                            <a href="<?= Url::to(['category/view', 'slug' => $catalog_woman->slug])?>" class="title">ЖЕНСКАЯ ОДЕЖДА</a>
                            <?php $children_woman = Category::findAll(['parent' => $catalog_woman->id])?>
                            <?php foreach ($children_woman as $child) :?>
                                <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="dropdown-catalog-section"><span><?= $child->name?></span></a>
                            <?php endforeach;?>
                        </div>
                        <?php endif;?>
                    </div>
                </li>
                <li><a href="<?= Url::to(['page/view', 'slug' => 'about-us'])?>" class="about-brend" data-id="about-brend-section">О БРЕНДЕ</a></li>
                <li class="delivery-parent"><a href="<?= Url::to(['page/view', 'slug' => 'delivery'])?>" class="delivery">ДОСТАВКА И ОПЛАТА</a>
                    <a href="javascript:;" class="delivery-icon"><img src="/data/img/tick.svg" alt=""></a></li>
                <li><a href="<?= Url::to(['page/view', 'slug' => 'contacts'])?>">КОНТАКТЫ</a></li>
            </ul>
        </nav>
    </div>  <!-- header-left -->

    <div class="header-right">
        <div class="phone-select-parent header-dropdown-parent">
            <a href="javascript:;" class="phone-select-mobile-btn"></a>
            <div class="phone-select">
                <div class="phone-select-btn">
                    <img src="/data/img/ph-icon.png" alt="" class="handset-icon">
                    <img src="/data/img/ph-icon-act.png" alt="" class="handset-icon handset-icon-active">
                    <a href="tel:+380731032086" class="main-number"><strong>+38 (073) 103-20-86</strong></a>
                    <a href="javascript:;" class="phone-select-icon"><img src="/data/img/tick.svg" alt=""></a>
                </div>
                <ul class="phone-select-dropdown">
                    <li>
                        <img src="/data/img/ph-oper1.svg" alt="">
                        <a href="tel:+380961032086">+38 <strong>(096) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper2.svg" alt="">
                        <a href="tel:+380961032086">+38 <strong>(050) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper3.png" alt="">
                        <a href="tel:+380501032086">+38 <strong>(050) 103-20-86</strong></a>
                    </li>
                    <li>
                        <img src="/data/img/ph-oper4.png" alt="">
                        <a href="tel:+380961032086">+38 <strong>(096) 103-20-86</strong></a>
                    </li>
                </ul>
            </div><!-- .phone-select -->
        </div><!-- .phone-select-parent -->

        <div class="callback-parent header-dropdown-parent">
            <a href="javascript:;" class="callback-btn">
                <img src="/data/img/callback-icon.svg" alt="" class="callback-icon">
                <img src="/data/img/callback-icon-active.svg" alt="" class="callback-icon callback-icon-active">
                <span>ПЕРЕЗВОНИТЕ МНЕ</span>
            </a>
            <div class="callback-dropdown">
                <form action="<?= Url::to(['order/fast'])?>" method="post">
                    <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                    <input type="text" name="Order[name]" placeholder="Введите ваше имя">
                    <input type="text" name="Order[phone]" placeholder="Номер мобильного">
                    <input type="submit" class="send" value="ОТПРАВИТЬ">
                </form>
            </div>          <!-- callback-dropdown -->
        </div>              <!-- callback-parent -->

        <div class="add-to-cart-parent header-dropdown-parent">

            <a href="javascript:;" class="add-to-cart-btn">
                <img src="/data/img/add-to-cart-button-image.svg" alt="" class="add-to-cart-icon">
                <img src="/data/img/add-to-cart-button-image-active.svg" alt="" class="add-to-cart-icon add-to-cart-icon-active">
                <span class="amount"><?= Yii::$app->cart->getCount()?></span>
            </a>

            <div class="dropdown-cart">
                <div class="thead">
                    <span class="title">ТОВАРЫ В КОРЗИНЕ:</span>
                    <span class="sum"><?= Yii::$app->cart->getCount()?> ШТ.</span>
                </div>
                <?php $cart = Yii::$app->cart; if (!$cart->getIsEmpty()) :?>
                        <?php
                        $items = $cart->items;
                        foreach ($items as $id => $item) :
                        ?>
                        <div class="dropdown-cart-item">
                            <a href="<?= Url::to(['item/view', 'slug' => $item->item->slug])?>" class="dropdown-cart-item-left">
                                <img src="<?= Image::thumb($item->item->getImage(
                                        ImageStorage::TYPE_MAIN)->file_path,
                                        Yii::getAlias('@front-web'), 65, 95)
                                ?>" alt="" class="dropdown-cart-item-image"></a>
                            <a href="<?= Url::to(['item/view', 'slug' => $item->item->slug])?>" class="dropdown-cart-item-right">
                                <span class="dropdown-cart-item-name"><?= $item->item->name ?></span>
                                <span class="dropdown-cart-item-options"><?= Size::findOne($item->size)->value ?> I <?= $item->item->color->name ?></span>
                                <div class="dropdown-cart-item-qty">
                                    <span><?= $item->quantity ?>  X</span>
                                    <strong><?= number_format($item->price, 0, '.', '')?> ГРН.</strong>
                                </div>
                            </a>
                            <a href="<?= Url::to(['cart/delete', 'id' => $id])?>" class="dropdown-remove-item"><img src="/data/img/x.png" alt=""></a>
                        </div>  <!-- dropdown-cart-item -->
                    <?php endforeach;?>
                    <div class="in-total">
                        <span class="title">ИТОГО:</span>
                        <span class="sum"><?= $cart->getCost(true)?> ГРН.</span>
                    </div>
                    <a href="javascript:;" class="dropdown-cart-checkout">ОФОРМИТЬ ЗАКАЗ</a>
                    <a href="<?= Url::to(['cart/view'])?>" class="dropdown-cart-gotocart">ПЕРЕЙТИ В КОРЗИНУ</a>
                <?php endif;?>
            </div>      <!-- add-to-cart-dropdown -->
        </div>              <!-- add-to-cart-parent -->
    </div>                  <!-- header-right -->
</header>

<?= $content ?>


<section class="subscribe-form dark mobile-hidden">
    <div class="wrap">
        <div class="subscribe-form-horizontal-wrap">
            <div class="subscribe">
                <div class="signup-form">
                    <form action="<?= Url::to(['subscriber/create'])?>" method="post">
                        <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                        <input type="text" name="Subscriber[name]" placeholder="Введи свое имя" required>
                        <input type="email" name="Subscriber[email]" class="email" placeholder="E-mail" required>
                        <input type="text" name="Subscriber[phone]" placeholder="Номер мобильного" required>
                        <input type="submit" class="send" value="ПОДПИСАТЬСЯ И ПОЛУЧИТЬ СКИДКУ 300 ГРН">
                    </form>

                </div>          <!-- signup-form -->
            </div>              <!-- subscribe -->
        </div>                  <!-- subscribe-form-horizontal-wrap -->
    </div>                      <!-- wrap -->
</section>                      <!-- subscribe-form -->

<footer>
    <div class="footer-top">
        <div class="footer-grid clearfix">
            <div class="footer-grid-item item1 mobile-col100">
                    <?php $children = Category::findAll(['parent' => 1])?>
                <span class="helpful">МУЖСКАЯ ОДЕЖДА</span>
                <?php foreach ($children as $child) :?>
                    <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="dropdown-catalog-section"><?= $child->name?></a>
                <?php endforeach;?>
            </div>      <!-- footer-grid item -->
            <?php if (1==0) :?>

            <div class="footer-grid-item item2 clearfix mobile-col100">
                <span class="helpful">ЖЕНСКАЯ ОДЕЖДА</span>
                <?php $children = Category::findAll(['parent' => 2])?>
                <?php foreach ($children as $child) :?>
                    <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="dropdown-catalog-section"><?= $child->name?></a>
                <?php endforeach;?>
            </div>      <!-- footer-grid item -->
            <?php endif;?>
            <div class="footer-grid-item item3 mobile-col100">
                <span class="helpful">ИНФОРМАЦИЯ</span>
                <?php $pages = Page::findAll(['status' => true])?>

                <?php foreach ($pages as $page) :?>
                    <a href="<?= Url::to(['page/view', 'slug' => $page->slug])?>" class="dropdown-catalog-section"><?= $page->name?></a>
                <?php endforeach;?>
            </div>

            <div class="footer-grid-item item4 mobile-col100">
                <span class="helpful">ПО ВОПРОСАМ СОТРУДНИЧЕСТВА</span>
                <a href="mailto:e.egoist-info@yandex.ru" class="footer-email">e.egoist-info@yandex.ru</a>
                <a href="tel:+380731032086" class="phone">+38 073 103-20-86</a>
                <a href="tel:+380731032086" class="phone">+38 073 103-20-86</a>
                <a href="tel:+380731032086" class="phone">+38 073 103-20-86</a>
            </div>

            <div class="footer-grid-item item5 mobile-col100">
                <span class="helpful">СЛЕДИТЕ ЗА НАШИМИ АНОНСАМИ В СОЦИАЛЬНЫХ СЕТЯХ</span>
                <div class="social-network">
                    <a href="https://www.facebook.com/egoist.me.ukraine"><img src="/data/img/fb-icon.png" alt=""></a>
                    <a href="https://vk.com/egoist_original"><img src="/data/img/vk-icon.png" alt=""></a>
                    <a href="https://www.instagram.com/egoist_original/"><img src="/data/img/i-icon.png" alt=""></a>
                </div>
                <a href="javascript:;" class="send-message"><img src="/data/img/message-icon.png" alt=""></a>
            </div>      <!-- footer-grid item -->
        </div>      <!-- footer-grid -->
    </div>      <!-- footer-top -->

    <div class="footer-bottom clearfix">
        <div class="copyright">© 2015-2016 "EGOIST"</div>
        <div class="copyright-jaws">
            Создание сайтов — <a title="Создание сайтов Киев" target="_blank" href="http://jaws.com.ua"><img src="/data/img/jaws.png" alt="Создание сайтов Киев"></a>
        </div>
    </div>      <!-- footer-bottom -->
</footer>

<div class="mobile-menu-wrap mobile-menu-block">
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <a href="javascript:;" class="close-menu-btn"><img src="/data/img/close.svg" alt=""></a>
        </div>             <!-- header-mobile -->

        <nav class="mobile-menu-nav">
            <ul>
                <li class="mobile-nav-parent">
                    <a href="javascript:;" class="mobile-nav-category" data-target="catalog-mobile">КАТАЛОГ</a>
                    <a href="javascript:;" class="mobile-nav-parent-btn"></a>
                </li>
                <li><a href="<?= Url::to(['page/view', 'slug' => 'about-us'])?>" class="mobile-nav-category">О БРЕНДЕ</a></li>
                <li class="mobile-nav-parent">
                    <a href="<?= Url::to(['page/view', 'slug' => 'delivery'])?>" class="mobile-nav-category">ДОСТАВКА И ОПЛАТА</a>
                    <a href="javascript:;" class="mobile-nav-parent-btn"></a>
                </li>
                <li><a href="<?= Url::to(['page/view', 'slug' => 'contacts'])?> " class="mobile-nav-category">КОНТАКТЫ</a></li>
            </ul>
        </nav>

    </div><!-- .mobile-menu -->
</div><!-- .mobile-menu-wrap -->

<div class="catalog-mobile mobile-menu-block">
    <div class="catalog-mobile-overlay"></div>
    <div class="catalog-mobile-menu">
        <div class="catalog-mobile-menu-header">
            <a href="javascript:;" class="mobile-menu-btn-backward"><img src="/data/img/backward-btn.svg" alt=""></a>
            <div class="catalog-title">КАТАЛОГ</div>
            <a href="javascript:;" class="close-menu-btn"><img src="/data/img/close.svg" alt=""></a>
        </div>             <!-- header-mobile -->

        <nav class="mobile-menu-nav">
            <div class="catalog-man">
                <a href="<?= Url::to(['category/view', 'slug' => $catalog_man->slug])?>" class="title"><span>МУЖСКАЯ ОДЕЖДА</span></a>
                <?php foreach ($children_man as $child) :?>
                    <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="catalog-section"><span><?= $child->name?></span></a>
                <?php endforeach;?>
            </div>
            <?php if (1==0) :?>
            <div class="catalog-woman">
                <a href="<?= Url::to(['category/view', 'slug' => $catalog_woman->slug])?>" class="title">ЖЕНСКАЯ ОДЕЖДА</a>
                <?php foreach ($children_woman as $child) :?>
                    <a href="<?= Url::to(['category/view', 'slug' => $child->slug])?>" class="catalog-section"><?= $child->name?></a>
                <?php endforeach;?>
            </div>
            <?php endif;?>
        </nav>


    </div><!-- .mobile-menu -->
</div><!-- catalog-mobile -->
<section class="popup-forms">
    <?php if (isset(Yii::$app->view->params['order'])) :?>

        <?php $order = Yii::$app->view->params['order'];?>
        <div class="cart-checkout-wrap">
            <div class="order-popup">
                <span class="order-popup-title">ОФОРМЛЕНИЕ ЗАКАЗА</span>
                <div class="order-popup-form">
                    <form action="<?= Url::to(['order/confirm'])?>" method="post">
                        <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                        <input type="text" name="Order[name]" class="required-fields" placeholder="Введите ваше имя" <?= $order->name ? "value=\"$order->name\"" : 'required'?>>
                        <input type="text" name="Order[phone]" class="required-fields" placeholder="Номер мобильного" <?= $order->phone ? "disabled value=\"$order->phone\"" : 'required'?>>
                        <input type="email" name="Order[email]" class="required-fields order-popup-email" placeholder="E-mail" required <?= $order->email ? "disabled value=\"$order->email\"" : 'required'?>>
                        <input type="text" name="Order[address]" class="order-popup-adress" placeholder="Введите адрес доставки">
                        <div class="custom-checkbox without-delivery">
                            <input name="Order[delivery]" type="checkbox" id="check1" value="1" />
                            <label for="check1" class="check-field">Доставка нужна</label>
                        </div>
                        <textarea name="Order[comment]" rows="5" cols="45" class="order-popup-comment" placeholder="Комментарий к заказу"></textarea>
                        <input type="submit" class="send" value="ОТПРАВИТЬ">
                        <strong>- поля обязательные для заполнения</strong>

                    </form>
                </div>
            </div><!-- order-popup -->
        </div>          <!-- cart-checkout-wrap -->

    <?php endif;?>

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
        </div>      <!-- popup-wait-form -->
    </div>          <!-- popup-success-form -->

    <div class="popup-message-sent-form">
        <div class="message-form">
            <a href="javascript:;" class="message-wrap"><strong>ВАШЕ СООБЩЕНИЕ<br>УСПЕШНО ОТПРАВЛЕНО!</strong></a>
        </div>      <!-- popup-wait-form -->
    </div>          <!-- popup-success-form -->
</section>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

<script src="/js/vendor/libs.js"></script>
<script src="/js/main.js"></script>
<script src="/js/vendor/yii.js"></script>
<script src="/js/vendor/bootstrap.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
