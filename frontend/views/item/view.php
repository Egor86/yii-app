<?php
/** @var array $items */
use common\helpers\Image;
use common\models\Category;
use common\models\Color;
use common\models\ImageStorage;
use yii\helpers\Url;

/** @var $model common\models\Item*/
/** @var $item common\models\Item*/
/** @var array $popular */
/** @var array $images */
/** @var array $same_items */
/** @var $image common\models\ImageStorage */
/* @var $this yii\web\View */

//$this->registerCssFile('css/img/normalize.min');
//$this->registerCssFile('css/img/libs');
//$this->registerCssFile('css/img/main');

$this->title = $model->name;
$seo = $model->seo;
$this->registerJs("
$(document).ready(function () {
    var data = { item_id: ".$model->id.", _csrf: '".Yii::$app->request->getCsrfToken()."'};
    $.ajax({
        type: 'post',
        url: '/item-size/check-amount.html',
        dataType: 'html',
        data: data,
        success: function(data) {
            if (data) {
                $('#item-sizes').html(data);
                $('#item-sizes').find('input:not([disabled])').first().attr('checked', true);
            }
        }        
    });
    
//    $.ajax({
//        type: 'post',
//        url: '/item-size/unavailable-size.html',
//        dataType: 'html',
//        data: data,
//        success: function(data) {
//            if (data) {
//                $('#pre-order').html(data);
//            }
//        }        
//    });
    
});

", \yii\web\View::POS_END);
?>

        <section class="page-header"> 
                <div class="breadcrumbs">
                    <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
                    <a href="<?= Url::to(['category/view',
                        'slug' => Category::findOne($model->product->category->parent)->slug
                    ]);?>" class="current-section"><span><?= Category::findOne($model->product->category->parent)->name?></span></a>
                    <a href="<?= Url::to(['category/view',
                        'slug' => $model->product->category->slug
                    ]);?>" class="current-section"><span><?= $model->product->category->name?></span></a>
                    <span class="current-item"><?= $model->name?></span>
                </div><!-- .breadcrumbs -->
                <a href="javascript:;" class="nav-prev-item"></a>
                <a href="javascript:;" class="nav-next-item"></a>
        </section>          <!-- page-header -->

        <section class="product-page">
            <div class="wrap">
                <div class="product-page-wrap">
                    <div id="products-slider-vertical" class="products-slider-vertical">
                        <div class="products-slider-vertical-wrap">
                            <a href="javascript:;" class="product-slider-btn product-slider-prev"></a>
                            <a href="javascript:;" class="product-slider-btn product-slider-next"></a>
                            <div id="gallery-2" class="royalSlider rsUni product-slider">
                                <?php foreach ($images as $image) : ?>
                                <a class="rsImg"
                                   data-rsBigImg="<?= Image::thumb($image->file_path,
                                    Yii::getAlias('@front-web'), 355, 515) ?>"
                                   href="<?= Image::thumb($image->file_path,
                                    Yii::getAlias('@front-web'), 355, 515) ?>">
                                    <img width="65" height="95" class="rsTmb" src="<?= Image::thumb($image->file_path,
                                        Yii::getAlias('@front-web'), 65, 95) ?>" /></a>
                                <?php endforeach; ?>
                                <?php if ($model->product->video && file_exists(Yii::getAlias('@front-web') . $model->product->video->url)) :?>
                                    <div class="rsContent">
                                        <video src="<?= $model->product->video->url?>" width="355" height="515" controls type="video/mp4"></video>
                                        <img width="96" height="72" class="rsTmb" src="<?= Image::thumb($images[0]->file_path,
                                            Yii::getAlias('@front-web'), 65, 95) ?>"  />
                                    </div>
                                 <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="content-wrap">
                        <div class="product-title mobile">
                            <strong class="product-name"><?= $model->name?></strong>
                            <span class="product-code">Код товара: <?= $model->stock_keeping_unit?></span>
                        </div>
                        <form action="cart/create.html" method="post" class="grid clearfix">
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                            <input type="hidden" name="Item[id]" value="<?= $model->id?>">
                            <div class="col50">
                                <div class="price-per-unit product-right-matchHeight">
                                    <?php if ($model->discount_price > 0) : ?>
                                    <span class="old-price-per-unit"><?= number_format($model->price, 0, '.', '')?> ГРН.</span>
                                    <span class="new-price-per-unit"><?= number_format($model->discount_price, 0, '.', '')?> ГРН.</span>
                                    <?php else: ?>
                                        <span class="price-per-unit"><?= number_format($model->price, 0, '.', '')?> ГРН.</span>
                                    <?php endif;?>
                                </div>
                            </div>      <!-- col50 --> 
                            <div class="col50">
                                <div class="product-amount product-right-matchHeight">
                                    <input type="text" name="Item[quantity]" class="pcs" value="1"><span>шт.</span>
                                    <input type="submit" class="add-to-cart" value="В КОРЗИНУ">
                                </div>
                            </div>      <!-- col50 -->
                            <div class="col50">
                                <div class="product-size product-right-matchHeight">
                                    <h5>РАЗМЕР: <a href="javascript:;">Таблица размеров</a></h5>
                                    <div id="item-sizes"></div>
                                </div>
                            </div>      <!-- col50 -->
                            <div class="col50">
                                <div class="product-color product-right-matchHeight">
                                    <h5>ЦВЕТ:</h5>
                                   <?= $this->render('_item_colors', ['model' => $model])?>
                                </div>          <!-- product-color -->
                            </div>      <!-- col50 -->
                        </form>            
                    <!-- PRICE BRACKET-ценовой диапазон, цена в квитанциях часто указывается per unit-за единицу товара, т.е. за штуку. -->
                        <div class="description grid clearfix">
                            <div class="col50">
                                <div class="product-description">
                                    <h5>ОПИСАНИЕ:</h5>
                                    <a href="javascript:;" class="open-btn open-btn-description"></a>
                                    <div class="product-description-content">
                                    <?= $model->product->description?>
                                    </div>
                                </div>      <!-- product-description -->
                            </div>          <!-- col50 -->
                            <div class="col50">
                                <div class="product-description">
                                    <h5>ОТЗЫВЫ:</h5>
                                    <a href="javascript:;" class="open-btn open-btn-review"></a>
                                    <a href="javascript:;" class="add-review-btn">ДОБАВИТЬ ОТЗЫВ</a>
                                    <div class="add-review-form clearfix">
                                        <form action="comment/add.html" method="post">
                                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                                            <input type="hidden" name="Comment[item_id]" value="<?= $model->id?>">
                                            <textarea rows="5" cols="45" name="Comment[text]" class="review-text" placeholder="Ваш отзыв"></textarea>
                                            <input type="text" class="review-name" name="Comment[user_name]" placeholder="Введи свое имя">
                                            <input type="email" class="review-email" name="Comment[email]" placeholder="E-mail" required>
                                            <input type="submit" class="send" value="ОТПРАВИТЬ">
                                        </form>
                                    </div>
                                    <?php foreach ($model->comments as $comment) : ?>
                                    <div class="review-item">
                                        <strong><?= $comment->user_name ?></strong>
                                        <span> - <?= date("d.m.Y", $comment->created_at) ?></span>
                                        <p><?= $comment->text ?></p>
                                    </div>
                                    <?php endforeach; ?>
                                    <a href="javascript:;" class="load-more-review">Загрузить еще</a>
                                </div>      <!-- product-description -->
                            </div>          <!-- col50 -->
                        </div>              <!-- grid -->
                    </div>                  <!-- content-wrap -->
                </div>                      <!-- product-page-wrap -->
            </div>                          <!-- wrap -->
        </section>

        <section class="top-items similar-items">
            <div class="wrap">
                <div class="section-header">
                    <strong>ПОХОЖИЕ ТОВАРЫ</strong>
                    <span>EGOIST</span>
                </div>
                <div id="products-slider" class="products-slider">
                    <?php foreach ($same_items as $item) : ?>
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
                    <?php endforeach; ?>
                </div><!-- .products-slider -->
            </div>
        </section>
