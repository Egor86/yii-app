<?php

use common\helpers\Image;
use common\models\ImageStorage;
use common\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var array $items */
/** @var $item common\models\Item*/
/** @var array $popular */

$this->title = 'Интернет-магазин стильной одежды - контакты, товары, услуги, цены | Ego-ist';

$limit = Item::ITEM_VIEW_LIMIT_DESKTOP;
if (Yii::$app->devicedetect->isMobile()) {
    $limit = Item::ITEM_VIEW_LIMIT_MOBILE;
}
$this->registerJs('
$(document).ready(function(){
   $("#imgLoad").hide();  //Скрываем прелоадер
});
var offset = '. $limit .'; //чтобы знать с какой записи вытаскивать данные
$(function() {
   $("#more").click(function(){ 
    event.preventDefault();
   $.ajax({
          url: "'. Url::to(['site/more']) .'",
          dataType: "html",
          type: "post",
          data: {offset: offset},
          cache: false,
          success: function(response){
              if(!response){  // смотрим ответ от сервера и выполняем соответствующее действие
                 notify("Больше нет новых товаров");
              }else{
                 $("#items").append(response).filter("img").load();
                 offset = offset + '. $limit .';
              }
           }
        });
    });
});
', \yii\web\View::POS_END)
?>
<section class="section-top clearfix" xmlns="http://www.w3.org/1999/html">
        <div class="grid clearfix">
            <div class="col66 mobile-hidden">
                <div class="section-top-item" style="background-image: url(data/img/image1.jpg)">
                    <span>ЛЕТНЯЯ<br>КОЛЛЕКЦИЯ ОБУВИ</span>
                    <a href="javascript:;" class="go-to-list">СМОТРЕТЬ</a>
                </div>
            </div>              <!-- col66 -->
            <div class="col33 mobile-col100">
                <div class="subscribe section-top-item" style="background-image: url(data/img/image4.jpg)">
                    <h4>ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ</h4>
                    <p>300 ГРН НА ЛЮБОЙ ЗАКАЗ</p>
                    <div class="signup-form">
                        <form action="subscriber/create.html" method="post">
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                            <input type="text" name="Subscriber[name]" placeholder="Введите ваше имя" required>
                            <input type="email" class="email" name="Subscriber[email]" placeholder="E-mail" required>
                            <input type="text" name="Subscriber[phone]" placeholder="Номер мобильного" required>
                            <input type="submit" class="send" value="ПОДПИСАТЬСЯ">
                        </form>
                        <strong>Мы не занимаемся рассылкой спама</strong>
                    </div>          <!-- signup-form -->
                </div>              <!-- subscribe -->
            </div>                  <!-- col33 -->
        </div>

        <div class="grid clearfix section-top-slider-wrap">
            <div class="col33 mobile-col100">
                <div class="section-top-item" style="background-image: url(data/img/image2.jpg)">
                    <span>МУЖСКИЕ<br>ФУТБОЛКИ</span>
                    <a href="javascript:;" class="go-to-list">СМОТРЕТЬ</a>
                </div>
            </div>          <!-- col33 -->
            <div class="col33 mobile-col100">
                <div class="section-top-item" style="background-image: url(data/img/image3.jpg)">
                    <span>ФУТБОЛКИ<br>И ПОЛО</span>
                    <a href="javascript:;" class="go-to-list">СМОТРЕТЬ</a>
                </div>
            </div>          <!-- col33 -->
            <div class="col33 mobile-col100">
                <div class="section-top-item" style="background-image: url(data/img/image5.jpg)">
                    <span>ЛЕТНЯЯ<br>КОЛЛЕКЦИЯ ОБУВИ</span>
                    <a href="javascript:;" class="go-to-list">СМОТРЕТЬ</a>
                </div>
            </div>          <!-- col33 -->
        </div>
    </section>

    <section class="represent-brend clearfix">
        <div class="wrap">
            <div class="section-header">
                <strong>EGO-IST -  АМБИЦИОЗНЫЙ БРЕНД</strong>
                <span>EGOIST</span>
            </div>
            <div class="grid clearfix">
                <div class="col33">
                    <div class="represent-brend-item" style="background-image: url(data/img/shape1.svg)">
                        <strong>ИНДИВИДУАЛЬНЫЙ ПОШИВ</strong>
                        <span>Каждая вещь идеально сидит на мужской фигуре и выгодно подчеркивает её достоинства.</span>
                    </div>
                </div>              <!-- col33 -->

                <div class="col33">
                    <div class="represent-brend-item" style="background-image: url(data/img/shape2.svg)">
                        <strong>100% НАТУРАЛЬНЫЕ МАТЕРИАЛЫ</strong>
                        <span>Все модели изготовлены из экологически чистого натурального текстиля. Ткань "дышит",<br> и в ней комфортно.</span>
                    </div>
                </div>              <!-- col33 -->

                <div class="col33">
                    <div class="represent-brend-item" style="background-image: url(data/img/shape3.svg)">
                        <strong>ОПРАВДАННАЯ ЦЕНА</strong>
                        <span>Цена каждой вещи эквивалентна ее ценности.<br> Ego Ist - Это новый уровень.</span>
                    </div>
                </div>              <!-- col33 -->
            </div>
        </div>                      <!-- wrap -->
    </section>

    <section class="subscribe-form">
        <div class="wrap">
            <div class="subscribe-form-horizontal-wrap">
                <div class="subscribe">
                    <h4>ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ</h4>
                    <p>300 ГРН НА ЛЮБОЙ ЗАКАЗ</p>
                    <strong>Мы не занимаемся рассылкой спама</strong>
                    <div class="signup-form">
                        <form action="subscriber/create.html" method="post">
                            <div class="grid clearfix">
                                <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                                <div class="col25"><input type="text" name="Subscriber[name]" placeholder="Введите ваше имя" required></div>
                                <div class="col25"> <input type="email" class="email" name="Subscriber[email]" placeholder="E-mail" required></div>
                                <div class="col25"><input type="text" name="Subscriber[phone]" placeholder="Номер мобильного" required></div>
                                <div class="col25"><input type="submit" class="send" value="ПОДПИСАТЬСЯ"></div>
                            </div>




                        </form>

                    </div>          <!-- signup-form -->
                </div>              <!-- subscribe -->
            </div>                  <!-- subscribe-form-horizontal-wrap -->
        </div>                      <!-- wrap -->
    </section>                      <!-- subscribe-form -->

    <section class="section-news">
        <div class="wrap">
            <div class="section-header">
                <strong>НОВИНКИ</strong>
                <span>EGOIST</span>
            </div>
            <div id="items" class="grid clearfix">
                <?php foreach ($items as $item) : ?>
                <div class="col25">
                    <div class="grid-product-item">
                        <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-image"><img src="<?php
                            $image = $item->getImage(ImageStorage::TYPE_MAIN);
                            echo $image ?
                                Image::thumb($image->file_path,
                                    Yii::getAlias('@front-web'), 260, 380) : ''
                            ?>" alt=""></a>

                        <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-bottom">
                            <span class="grid-product-item-name"><?= $item->name?></span>
                            <span class="grid-product-item-price"><?= number_format($item->price, 0, '.', '')?> ГРН.</span>
                            <span class="grid-product-item-btn">ПОДРОБНЕЕ</span>
                        </a>
                    </div>
                </div>            <!-- col25 -->
                <?php endforeach; ?>

            </div>                  <!-- grid -->
            <a id="more" href="#" class="add-more-item">ЗАГРУЗИТЬ ЕЩЕ</a>
        </div>                      <!-- wrap -->
    </section>

    <section class="about-brend-section clearfix mobile-hidden" id="about-brend-section">
        <div class="wrap">
            <div class="about-brend-section-wrap">
                <div class="section-header">
                    <strong>КАЖДАЯ ДЕТАЛЬ ПРОДУМАНА ДО МЕЛОЧЕЙ.</strong> <strong>ОДЕЖДА EGO-IST ИДЕАЛЬНО СИДИТ НА ЛЮБОЙ ФИГУРЕ.</strong>

                </div>
                <div class="grid clearfix">
                    <div class="col25">
                        <div>
                            <img src="data/img/detal-image1.jpg" alt="">
                        </div>
                        <div class="content">
                            Для производства используется высокопрочная ткань пике, премиального качества, которая несмотря на плотность имеет хорошую воздухопроницаемость и позволяет коже дышать.
                        </div>
                    </div>              <!-- col25 -->

                    <div class="col25">
                        <div>
                            <img src="data/img/detal-image2.jpg" alt="">
                        </div>
                        <div class="content">
                            Пошив осуществляется в Украине лучшими мастерами и соответствует высокому качеству зарубежных материалов. Мы тщательно следим за производственным процессом.
                        </div>
                    </div>              <!-- col25 -->

                    <div class="col25">
                        <div>
                            <img src="data/img/detal-image3.jpg" alt="">
                        </div>
                        <div class="content">
                            Специальная технология пошива с укрепленными тройными швами. Кроме того, для пошива используется специальная нить, которая после пошива распаивается и делает шов вечным.
                        </div>
                    </div>              <!-- col25 -->

                    <div class="col25">
                        <div>
                            <img src="data/img/detal-image4.jpg" alt="">
                        </div>
                        <div class="content">
                            Специальная технология пошива с укрепленными тройными швами. Кроме того, для пошива используется специальная нить, которая после пошива распаивается и делает шов вечным.
                        </div>
                    </div>              <!-- col25 -->
                </div>
            </div>                 <!-- about-brend-section-wrap -->
        </div>                      <!-- wrap -->
    </section>

    <section class="represent-brend delivery mobile-hidden">
        <div class="wrap">
            <div class="section-header">
                <strong>ЧТО ПРОИСХОДИТ СРАЗУ ПОСЛЕ ОТПРАВКИ ЗАКАЗА</strong>
                <span>EGOIST</span>
            </div>
            <div class="grid clearfix">
                <div class="col25">
                    <div class="represent-brend-item delivery-item" style="background-image: url(data/img/shape4.svg)">
                    <span>Наш менеджер связывается с Вами в течении 2 часов с момента получения заявки и вы согласовываете все необходимые детали.</span>
                    </div>
                </div>              <!-- col25 -->

                <div class="col25">
                    <div class="represent-brend-item delivery-item" style="background-image: url(data/img/shape5.svg)">
                    <span>Курьер доставляет Ваш заказ к Вам домой. По Украине доставка Новой Почтой. И да, доставка любым способом абсолютно БЕСПЛАТНАЯ!</span>
                    </div>
                </div>              <!-- col25 -->

                <div class="col25">
                    <div class="represent-brend-item delivery-item" style="background-image: url(data/img/shape6.svg)">
                    <span>Вы оплачиваете товар при получении. Если не подошел размер или что-то Вас не устроило, обмен и возврат за наш счет и без обьяснений.</span>
                    </div>
                </div>              <!-- col25 -->

                <div class="col25">
                    <div class="represent-brend-item delivery-item" style="background-image: url(data/img/shape7.svg)">
                    <span>Вы получаете гарантию от 40 до 70 циклов (2 года) стирки при рекомендованном уходе на любую продукцию марки Egoist.</span>
                    </div>
                </div>              <!-- col25 -->
            </div>
        </div>                      <!-- wrap -->
    </section>

    <section class="top-items">
        <div class="wrap">
            <div class="section-header">
                <strong>ПОПУЛЯРНЫЕ ТОВАРЫ</strong>
                <span>EGOIST</span>
            </div>
            <div id="products-slider" class="products-slider">

                <?php $flags = ['new', 'sale', 'top'];  foreach ($popular as $item) : ?>
                <div class="grid-product-item <?php if ($item->created_at > strtotime(date('Y-m-d', strtotime('-7 days')))){
                    echo 'new';
                } elseif($item->discount_price > 0) {
                    echo 'sale';
                } else {
                    echo 'top';

                }?>">
                    <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-image"><img src="<?php
                        $image = $item->getImage(ImageStorage::TYPE_MAIN);
                        echo $image ?
                            Image::thumb($image->file_path,
                                Yii::getAlias('@front-web'), 260, 380) : ''
                        ?>" alt=""></a>

                    <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-bottom">
                        <span class="grid-product-item-name"><?= $item->name?></span>
                        <span class="grid-product-item-price"><?= number_format($item->price, 0, '.', '')?> ГРН.</span>
                        <span class="grid-product-item-btn">ПОДРОБНЕЕ</span>
                    </a>
                </div>
                <?php endforeach; ?>

            </div><!-- .products-slider -->
        </div>
    </section>
