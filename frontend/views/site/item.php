<?php

/** @var array $items */
/** @var $item common\models\Item*/
use common\helpers\Image;
use common\models\ImageStorage;
use yii\helpers\Url;
?>
<?php foreach ($items as $item) : ?>
    <div class="col25">
        <div class="grid-product-item">
            <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-image"><img src="<?=
                Image::thumb($item->getImage(
                    ImageStorage::TYPE_MAIN)->file_path,
                    Yii::getAlias('@front-web'), 260, 380)
                ?>" alt=""></a>

            <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="grid-product-item-bottom">
                <span class="grid-product-item-name"><?= $item->name?></span>
                <span class="grid-product-item-price"><?= number_format($item->price, 0, '.', '')?> ГРН.</span>
                <span class="grid-product-item-btn">ПОДРОБНЕЕ</span>
            </a>
        </div>
    </div>            <!-- col25 -->
<?php endforeach; ?>
