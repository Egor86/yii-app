<?php

/* @var $this yii\web\View */
/** @var array $items */

use common\helpers\Image;
use common\models\ImageStorage;
use common\models\Size;
use yii\helpers\Url;

$this->title = 'КОРЗИНА';

?>

        <section class="page-header"> 
                <div class="breadcrumbs">
                    <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
                    <span class="current-item cart">КОРЗИНА</span>
                </div><!-- .breadcrumbs -->
                <a href="javascript:;" class="nav-prev-item cart"></a>
                <a href="javascript:;" class="nav-next-item cart"></a>
        </section>          <!-- page-header -->

        <section class="cart-page">
            <div class="wrap">
                <h2>КОРЗИНА</h2>

                <div class="cart-page-columns clearfix">
                    <div class="cart-left">
                        <div class="cart-selected-items">

                            <div class="column-head">
                                <span class="w65">ТОВАР</span>
                                <span class=""></span>
                                <span class="w20">ХАРАКТЕРИСТИКА</span>
                                <span class="w110">КОЛИЧЕСТВО</span>
                                <span class="w16">СУММА</span>
                                <span class="w30"></span>
                            </div>
                            <div class="column-head-mobile">
                                <span class="w65">ТОВАР</span>
                                <span class=""><?= Yii::$app->cart->getCount()?> ШТ.</span>
                            </div>
                            <?php foreach ($items as $id => $item) :?>
                            <div class="cart-selected-product-wrap">
                                <a href="<?= Url::to(['item/view', 'slug' => $item->item->slug])?>" class="column-left w65">
                                    <img src="<?= Image::thumb($item->item->getImage(ImageStorage::TYPE_MAIN)->file_path, Yii::getAlias('@front-web'), 65, 95)
                                    ?>" alt="">
                                </a>    

                                <a href="<?= Url::to(['item/view', 'slug' => $item->item->slug])?>" class="column-right">
                                    <span class="item-name"><?= $item->item->name?></span>
                                    <span class="item-category"><?= $item->item->product->category->name?></span>
                                    <strong class="per-unit product-right-matchHeight">
                                        <?php if ($item->item->discount_price > 0) : ?>
                                            <span class="old-price-per-unit"><?= number_format($item->item->price, 0, '.', '')?> ГРН.</span>
                                            <span class="new-price-per-unit"><?= number_format($item->item->discount_price, 0, '.', '')?> ГРН.</span>
                                        <?php else: ?>
                                            <span class="price-per-unit"><?= number_format($item->item->price, 0, '.', '')?> ГРН.</span>
                                        <?php endif;?>
                                    </strong>
                                </a>
                                
                                <div class="cart-selected-product-specification w20">
                                    <span>Цвет: <?= $item->item->color->name ?></span>
                                    <span>Размер: <?= Size::findOne($item->size)->value ?></span>
                                    <a href="<?= Url::to(['cart/delete', 'id' => $id, 'slug' => $item->item->slug])?>">Изменить</a>
                                </div>

                                <div class="cart-selected-product-qt w110">
                                        <form action="<?= Url::to(['cart/update'])?>" method="post">
                                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                                            <input type="hidden" name="name" value="quantity">
                                            <input type="hidden" name="pk" value="<?= $id?>">
                                            <div class="qty-input">
                                            <input type="submit" class="qty-less" name="value" <?= $item->getQuantity() <= 1 ? 'disabled' : 'value="'. ($item->getQuantity() - 1) . '"'?>>
                                            <span class="pcs" ><?= $item->quantity?></span>
                                            <input type="submit" name="value" class="qty-more" value="<?= $item->quantity + 1?>">
                                            </div>          <!-- qty-input -->
                                        </form>
                                </div>

                                <div class="cart-selected-product-amount w16 qty-input">
                                    <strong class="sum"><?= $item->quantity * $item->price?> ГРН.</strong>
                                </div>

                                <div class="cart-selected-product-remove w30">
                                    <a href="<?= Url::to(['cart/delete', 'id' => $id])?>" class="delete"><img src="data/img/x.png" alt=""></a>
                                    <a href="<?= Url::to(['cart/delete', 'id' => $id])?>" class="remove-item"><img src="data/img/x.png" alt=""></a>
                                </div>
                            </div>                    <!-- cart-selected-product-wrap -->
                            <?php endforeach;?>

                        </div>              <!-- selected items -->
                        <div class="cart-page-bottom">
                            <a href="<?= Url::to(['category/view', 'slug' => array_pop($items)->item->product->category->slug])?>" class="continue-shopping">Продолжить покупки</a>
                            <a href="<?= Url::to(['cart/checkout'])?>" class="remove-all">Очистить корзину</a>
                        </div>
                    </div>                  <!-- cart-left -->

                    <div class="cart-right">
                        <div class="cart-selected-product-total w280">
                            <div class="cart-selected-product-total-wrap">
                                <?php if (Yii::$app->session['discount']) : ?>
                                <span class="enter-code">КОД АКТИВИРОВАН УСПЕШНО</span>
                                <?php else:?>
                                <a href="Javascript:;" class="enter-code"><span>У МЕНЯ ЕСТЬ ПРОМОКОД</span></a>
                                <div class="promo-form subscribe">
                                    <form action="<?= Url::to(['coupon/verify'])?>" method="post">
                                        <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                                        <input type="text" name="CouponForm[email]" placeholder="Введи свой email" required>
                                        <input type="text" name="CouponForm[phone]" placeholder="Номер мобильного" required>
                                        <input type="text" name="CouponForm[coupon_code]" placeholder="Код купона" required>
                                        <input type="submit" class="send" value="АКТИВИРОВАТЬ">
                                    </form>
                                </div>
                                <?php endif;?>
                                <div class="sum-total">
                                    <table class="top-row">
                                        <tr>
                                            <td>Суммарная стоимость:</td>
                                            <td class="right"><?= Yii::$app->cart->getCost()?> ГРН.</td>
                                        </tr>
                                        <tr>
                                            <td>Промокод:</td>
                                            <td class="right"><?= $coupon_form->coupon ? $coupon_form->coupon->campaign->discount . ' ГРН.' : 0 ?></td>
                                        </tr>
                                    </table>
                                    <table class="bottom-row">
                                        <tr>
                                            <td>Итого:</td>
                                            <td class="right total"><?= Yii::$app->cart->getCost(true)?> ГРН.</td>
                                        </tr>
                                    </table>
                                    <a href="javascript:;" class="cart-checkout">ОФОРМИТЬ ЗАКАЗ</a>
                                </div>      <!-- sum-total --> 

                                </div>
                            </div>
                        </div>                  <!-- cart-selected-product-total w280 -->
                    </div>                      <!-- cart-right -->
                    
                </div>
            </div>                              <!-- wrap -->
        </section>                              <!-- cart-page -->
