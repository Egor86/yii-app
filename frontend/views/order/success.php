<?php

use common\helpers\Image;
use common\models\ImageStorage;
use common\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var $model common\models\Order*/
/** @var array $items */

$this->title = 'ВАШ ЗАКАЗ УСПЕШНО ОФОРМЛЕН';

?>

    <section class="page-header" >
        <div class="breadcrumbs">
            <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
            <span class="current-item cart">ВАШ ЗАКАЗ УСПЕШНО ОФОРМЛЕН</span>
        </div><!-- .breadcrumbs -->
        <!-- <a href="javascript:;" class="nav-prev-item cart"></a>
        <a href="javascript:;" class="nav-next-item cart"></a> -->
    </section>          <!-- page-header -->

    <section class="cart-page ordered">
        <div class="wrap">
            <h2>ВАШ ЗАКАЗ УСПЕШНО ОФОРМЛЕН!</h2>
            <h4>Заказ <strong><?= $model->id?></strong> был успешно оформлен и отправлен нашему менеджеру.</h4>
            <h4>С Вами свяжутся в ближайшее время для подтверждения заказа и уточнения деталей.</h4>
            <h5>СОСТАВ ЗАКАЗА</h5>

            <div class="grid clearfix">

                <div class="column-head-mobile">
                    <span class="w65">ТОВАР</span>
                    <span class=""><?= array_sum(ArrayHelper::getColumn($items, 'quantity'))?> ШТ.</span>
                </div>
                <?php foreach ($items as $item) : ?>
                    <div class="col25">
                        <a href="<?= Url::to(['item/view', 'slug' => $item->item->slug])?>" class="order-item clearfix">
                            <div class="order-item-image"><img src="<?=
                                Image::thumb($item->item->getImage(ImageStorage::TYPE_MAIN)->file_path, Yii::getAlias('@front-web'), 65, 95)
                                ?>" alt=""></div>
                            <div class="order-item-description clearfix">
                                <span class="item-name"><?= $item->item->name?></span>
                                <span class="item-category"><?= $item->item->product->category->name?></span>
                                <p class="options">Цвет: <?= $item->item->color->name ?></p>
                                <p class="options">Размер: <?= Size::findOne($item->size)->value ?></p>
                                <strong class="per-unit product-right-matchHeight">
                                    <span class="item-qty"><?= $item->quantity?>  X</span>
                                    <?php if ($item->item->discount_price > 0) : ?>
                                        <span class="old-price-per-unit"><?= number_format($item->item->price, 0, '.', '')?> ГРН.</span>
                                        <span class="new-price-per-unit"><?= number_format($item->item->discount_price, 0, '.', '')?> ГРН.</span>
                                    <?php else: ?>
                                        <span class="price"><?= number_format($item->item->price, 0, '.', '')?> ГРН.</span>
                                    <?php endif;?>
                                </strong>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>                          <!-- grid -->
            <div class="ordered-bottom">
                <p class="intotal">Общее количество товаров: <strong><?= array_sum(ArrayHelper::getColumn($items, 'quantity'))?> шт.</strong></p>
                <p class="sum-intotal">Общая стоимость товаров: <strong><?= $model->total_cost?> грн.</strong></p>
            </div>

            <div class="ordered-page-bottom">
                <p>СПАСИБО, ЧТО ВЫБРАЛИ НАШ МАГАЗИН!</p>

                <a href="<?= Yii::$app->getHomeUrl()?>" class="continue-shopping">На главную</a>
            </div>
        </div>                              <!-- wrap -->
    </section>                              <!-- cart-page -->
