<?php

/** @var $model common\models\Page*/

$this->title = $model->name;
?>

<section class="page-header">
    <div class="breadcrumbs">
        <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
        <span class="current-item cart"><?= $model->name?></span>
    </div><!-- .breadcrumbs -->
    <!--  <a href="javascript:;" class="nav-prev-item cart"></a>
     <a href="javascript:;" class="nav-next-item cart"></a> -->
</section>          <!-- page-header -->
<section class="about-brand">
    <div class="wrap">
        <div class="about-brand-head-blok">
            <h2><?= $model->name?></h2>
        </div>
        <div class="about-brand-content">
            <div class="about-brand-text">
                <?= $model->text?>
            </div>
        </div>

    </div>                              <!-- wrap -->
</section>