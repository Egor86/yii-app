<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Page */
if (Yii::$app->session->hasFlash('success')) {

    $this->registerJs('
            function popupSuccess() {
                $.colorbox({
                  inline: true,
                  href: \'.popup-message-sent-form\',      
                  transition: \'none\',
                  onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
                });
            };
            popupSuccess();
    ', \yii\web\View::POS_END);
}

$this->title = 'КОНТАКТЫ';

?>
    <section class="page-header">
        <div class="breadcrumbs">
            <a href="<?= Yii::$app->getHomeUrl()?>"class="home-page-section"><span>ГЛАВНАЯ</span></a>
            <span class="current-item cart">КОНТАКТЫ</span>
        </div><!-- .breadcrumbs -->
        <!--  <a href="javascript:;" class="nav-prev-item cart"></a>
         <a href="javascript:;" class="nav-next-item cart"></a> -->
    </section>          <!-- page-header -->

    <section class="about-brand contacts">
        <div class="wrap">
            <div class="about-brand-head-blok">
                <h2>КОНТАКТЫ</h2>
            </div>
            <div class="grig contacts-grid clearfix">
                <div class="col25">
                    <div class="address">
                        <h4>АДРЕС:</h4>
                        <p><?= $model->text?></p>
                    </div>
                </div>
                <div class="col25">
                    <div class="phones">
                        <h4>ТЕЛЕФОНЫ:</h4>
                        <ul class="phone-list">
                            <li>
                                <img src="/data/img/ph-icon.png" alt="" class="handset-icon">
                                <a href="tel:+380731032086">+38 (073) 103-20-86</a>
                            </li>
                            <li>
                                <img src="/data/img/ph-oper1.svg" alt="">
                                <a href="tel:+380961032086">+38 (096) 103-20-86</a>
                            </li>
                            <li>
                                <img src="/data/img/ph-oper2.svg" alt="">
                                <a href="tel:+380961032086">+38 (050) 103-20-86</a>
                            </li>
                            <li>
                                <img src="/data/img/ph-oper3.png" alt="">
                                <a href="tel:+380501032086">+38 (050) 103-20-86</a>
                            </li>
                            <li>
                                <img src="/data/img/ph-oper4.png" alt="">
                                <a href="tel:+380961032086">+38 (096) 103-20-86</a>
                            </li>
                        </ul>               <!-- phone-list -->
                    </div>
                </div>
                <div class="col50">
                    <div class="feedback">
                        <div class="feedback-form-wrap">
                            <h3>ОБРАТНАЯ СВЯЗЬ:</h3>
                            <form action="<?= Url::to(['site/contact'])?>" method="post" class="feedback-form clearfix">
                                <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken?>">
                                <input type="text" name="ContactForm[name]" placeholder="Ваше имя" required>
                                <input type="text" name="ContactForm[phone]" placeholder="Контактный телефон" class="tel">
                                <input type="email" class="email" name="ContactForm[email]" placeholder="E-mail" required>
                                <div class="selectmenu">
                                    <select name="ContactForm[subject]" id="">
                                        <option value="Отдел продаж">Отдел продаж</option>
                                        <option value="Клиент сервис">Клиент сервис</option>
                                        <option value="Техподдержка">Техподдержка</option>
                                        <option value="Предложения и отзывы">Предложения и отзывы</option>
                                        <option value="Сотрудничество">Сотрудничество</option>
                                        <option value="другое">другое</option>
                                    </select>
                                </div>    <!-- form-middle-width -->
                                <textarea rows="5" cols="45" name="ContactForm[body]" placeholder="Сообщение" required></textarea>
                                <div class="g-recaptcha recaptcha" data-sitekey="6Leeqg0UAAAAAC5BqKlyPuLXX_Xog_EMRX1Q0xxX"></div>
                                <input type="submit" class="send" value="ОТПРАВИТЬ">
                            </form>
                        </div>
                    </div>
                </div>
            </div>                              <!-- wrap -->
    </section>