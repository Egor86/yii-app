<?php

/** @var $this \yii\web\View*/
use common\helpers\Image;
use common\models\Category;
use common\models\Color;
use common\models\ImageStorage;
use common\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $sort \yii\data\Sort*/
/** @var $itemSearch frontend\models\ItemSearch*/
/** @var array $items*/
/** @var $item common\models\Item*/
/** @var $model common\models\Category */

$this->title = $model->name;

?>


<section class="page-header category">
    <div class="breadcrumbs">
        <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
        <?php if ($model->parent) : ?>
            <a href="<?= Url::to(['category/view',
                'slug' => Category::findOne($model->parent)->slug
            ]);?>" class="home-page-section"><span><?= Category::findOne($model->parent)->name?></span></a>
        <?php endif;?>
        <span class="current-item cart"><?= $model->name?></span>
    </div><!-- .breadcrumbs -->
    <!--  <a href="javascript:;" class="nav-prev-item cart"></a>
     <a href="javascript:;" class="nav-next-item cart"></a> -->
</section>          <!-- page-header -->
<section class="page-header-mobile-category">
    <div class="breadcrumbs">
        <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
        <?php if ($model->parent) : ?>
            <a href="<?= Url::to(['category/view',
                'slug' => Category::findOne($model->parent)->slug
            ]);?>" class="home-page-section"><span><?= Category::findOne($model->parent)->name?></span></a>
        <?php endif;?>
        <span class="current-item cart"><?= $model->name?></span>
    </div><!-- .breadcrumbs -->

</section>          <!-- page-header -->

<section class="category">
    <form action="<?= Url::to(['category/view', 'slug' => $model->slug])?>" class="wrap" method="get">
        <div class="category-head-blok">
            <div class="head-blok-left">
                <h2><?= $model->parent ? Category::findOne($model->parent)->name : $model->name?></h2>
                <a href="javascript:;" class="filter-mobile-dropdown">ФИЛЬТР</a>
            </div>
            <div class="head-blok-right">
                <div class="sort-by">
                    <strong>Сортировать по:</strong>
                    <div class="selectmenu form-middle-width">
                        <select name="sort" id="">
                            <option <?= Yii::$app->request->getQueryParam('sort') == '-new' ||
                                Yii::$app->request->getQueryParam('sort')  === null ?
                                    'selected="selected"' : ''?> value="-new">Сначала новые</option>
                            <option <?= Yii::$app->request->getQueryParam('sort') == '-price_high' ?
                                'selected="selected"' : ''?> value="-price_high">Сначала дорогие</option>
                            <option <?= Yii::$app->request->getQueryParam('sort') == 'price_low' ?
                                'selected="selected"' : ''?> value="price_low">Сначала дешевые</option>
                            <option <?= Yii::$app->request->getQueryParam('sort') == 'discount' ?
                                'selected="selected"' : ''?> value="discount">Только со скидкой</option>
                        </select>
                    </div>    <!-- form-middle-width -->
                </div>          <!-- sort-by -->
                <div class="show-by">
                    <strong>Показывать по:</strong>
                    <div class="selectmenu form-small-width">
                        <select name="limit[]" id="">
                            <option <?= Yii::$app->request->getQueryParam('limit') == 30 ||
                            Yii::$app->request->getQueryParam('limit')  === null ?
                                'selected="selected"' : ''?>value="30">30</option>
                            <option <?= Yii::$app->request->getQueryParam('limit') == 60 ?
                                'selected="selected"' : ''?> value="60">60</option>
                        </select>
                    </div>      <!-- form-middle-width -->
                </div>          <!-- show-by -->
            </div>              <!-- head-blok-right -->
        </div>


        <div class="grid category-columns clearfix">
            <div class="grid-item col20">
                <div class="menswear">
                    <a href="javascript:;" class="title"><span>КАТЕГОРИИ</span></a>
                    <?php
                    $categories = Category::findAll(['parent' => $model->parent ? $model->parent : $model->id]);
                    foreach ($categories as $category) :
                        ?>
                        <a href="<?= Url::to(['category/view',
                            'slug' => $category->slug]);?>" class="catalog-section <?= $category->id == $model->id ? 'active' : '' ?>">
                            <span><?= $category->name ?></span>
                        </a>
                    <?php endforeach;?>
                </div>

                <div class="menswear filter">
                    <a href="javascript:;" class="title"><span>ФИЛЬТР</span></a>
                    <strong>ЦВЕТ:</strong>

                    <div class="filter-scrollable">
                        <?php foreach (Color::find()->all() as $index => $color) : ?>
                            <div class="custom-checkbox catalog-section">
                                <input type="checkbox" name="color[]"
                                    <?= is_array($itemSearch->color) && in_array($color->id, $itemSearch->color) ? 'checked' : '' ?>
                                       id="check<?= $index?>" value="<?= $color->id?>" />
                                <label for="check<?= $index?>" class="check-field"><?= $color->name?></label>
                            </div>
                        <?php endforeach;?>
                    </div>               <!-- filter-scrollable -->

                    <div class="filter-size">
                        <strong class="size">РАЗМЕР:</strong> <a href="javascript:;" class="size-chart">Таблица размеров</a>

                        <div class="filter-scrollable">
                            <?php foreach (Size::findAll(['size_table_name_id' => $model->size_table_name_id]) as $index => $size) : ?>
                                <div class="custom-checkbox catalog-section">
                                    <input type="checkbox" name="size[]" id="check<?= $index?>0"
                                        <?= is_array($itemSearch->size) && in_array($size->id, $itemSearch->size) ? 'checked' : '' ?> value="<?= $size->id?>" />
                                    <label for="check<?= $index?>0" class="check-field"><?= $size->value?></label>
                                </div>
                            <?php endforeach;?>
                        </div>               <!-- filter-scrollable -->
                    </div>

                    <div class="filter-price">
                        <strong class="price">ЦЕНА:</strong>
                        <div class="form-slider">
                            <div class="range">
                                <strong class="from">От:</strong>
                                <strong class="to">До:</strong>
                            </div>

                            <div class="price-range-slider" data-max="5000" data-values="500,3000"></div>

                            <div class="sidebar-wrap">
                                <input type="text" name="min" id="sidebar-price-from" class="price-from" value="<?= $itemSearch->min ? $itemSearch->min : 0 ?>"> <span class="unit">грн.</span>
                                <input type="text" name="max" id="sidebar-price-to" class="price-to" value="<?= $itemSearch->max ? $itemSearch->max : 0 ?>"> <span class="unit">грн.</span>
                            </div>
                        </div>

                    </div>              <!-- filter-price -->
                    <div class="filter-submit">
                        <?php $param = Yii::$app->request->getQueryParams();
                        if (isset($param['slug'])){ unset($param['slug']); };
                        if (!empty($param)) : ?>
                        <a href="<?= Url::to(['category/view', 'slug' => $model->slug])?>" class="clear-all">Очистить фильтр</a>
                        <?php endif;?>
                        <input type="submit" value="Подобрать" class="to-find">
                    </div>
                </div>                  <!-- filter -->



            </div>

            <div class="grid-item col80">
                <div class="grid inserted clearfix">
                    <?php foreach ($dataProvider->getModels() as $item) : ?>
                        <div class="grid-item col25">
                            <div class="grid-product-item <?php if ($item->recommended){
                                echo 'top';
                            } elseif($item->discount_price > 0) {
                                echo 'sale';
                            } elseif($item->created_at > strtotime(date('Y-m-d', strtotime('-7 days')))) {
                                echo 'new';

                            }?>">
                                <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-image">
                                    <img src="<?php
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
                            </div>              <!-- grid-product-item -->
                        </div>
                    <?php endforeach; ?>
                </div>                  <!-- grid -->
                <div class="bottom-blok-right">

                    <?= common\widgets\MyLinkPager::widget([
                    'pagination'=>$dataProvider->pagination,
                        'options' => ['class' => 'sort-by'],
//                        'maxButtonCount' => 5,
                        'hideOnSinglePage' => false

                    ]);?>

                    <div class="show-by">
                        <strong>Показывать по:</strong>
                        <div class="selectmenu form-small-width">
                            <select name="limit[]" id="">
                                <option <?= Yii::$app->request->getQueryParam('limit') == 30 ||
                                Yii::$app->request->getQueryParam('limit')  === null ?
                                    'selected="selected"' : ''?>value="30">30</option>
                                <option <?= Yii::$app->request->getQueryParam('limit') == 60 ?
                                    'selected="selected"' : ''?> value="60">60</option>
                            </select>
                        </div>      <!-- form-middle-width -->
                    </div>          <!-- show-by -->
                </div>              <!-- bottom-blok-right -->
            </div>                      <!-- col80 -->


        </div>
    </form>                              <!-- wrap -->
</section>                              <!-- category -->

