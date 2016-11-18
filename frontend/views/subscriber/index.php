<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>EGOIST</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/soon/normalize.min.css">
        <link rel="stylesheet" href="/css/soon/libs.css">
        <link rel="stylesheet" href="/css/soon/bootstrap.css">
        <link rel="stylesheet" href="/css/soon/main.css">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&amp;subset=cyrillic" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans+Narrow" rel="stylesheet">

        <script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-83958980-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter36069305 = new Ya.Metrika({
                        id:36069305,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/36069305" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


        <header>
            <div class="wrap">
                <div class="header-wrap">
                    <div class="header-left">
                       <div><img src="/data/soon/img/logo.png" class="logo" alt=""></div>
                    </div>
                    <div class="header-right">
                        <h1>МЫ В ОЖИДАНИИ ОТКРЫТИЯ САМОГО ДЕРЗКОГО ИНТЕРНЕТ-МАГАЗИНА МУЖСКОЙ ОДЕЖДЫ.</h1>
                        <h3>А ТЫ С НАМИ?</h3>
                    </div>
                </div>
            </div>      <!-- wrap -->
        </header>

        <!-- Modal -->
        <div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <div class="form-group has-error">
                            <div id="result"></div>
                        </div> <!-- For error message -->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <section class="container clearfix">

            <div class="wrap">
                <div class="section-left clearfix">
                    <div class="subscribe">
                        <h4>ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ</h4>
                        <p>150 ГРН НА ПОКУПКУ</p>
                        <span class="get-gift">+ ГАРАНТИРОВАННО ЦЕННЫЙ ПОДАРОК</span>

                        <div class="signup-form">
                            <?php $form = ActiveForm::begin(['action' => null, 'id' => 'subscribe']); ?>
                                <span class="helper">Введи своё имя</span>
                                    <?= Html::activeTextInput($model, 'name',['class' => 'first-name', 'required' => true])?>
                                <span class="helper">E-mail</span>
                                    <?= Html::activeInput('email', $model, 'email',['class' => 'email', 'required' => true])?>
                                <span class="helper">Номер мобильного</span>
                                    <?= Html::activeTextInput($model, 'phone',[
                                        'class' => 'phone-number',
                                        'required' => true,])?>
                                <input type="submit" id="submit" class="send" value="ПОДПИСАТЬСЯ">
<!--                            </form>-->
                            <?php ActiveForm::end(); ?>
                            <strong>Успешные парни принимают решение мгновенно,<br>когда речь заходит о собственной выгоде!</strong>
                        </div>      <!-- signup-form -->
                    </div>
                    <div class="social-network">
                        <a href="https://vk.com/egoist_original" target="_blank"><img src="/data/soon/img/vk-xxl.png" alt=""></a>
                        <a href="https://www.facebook.com/egoist.me.ukraine" target="_blank"><img src="/data/soon/img/facebook-icon.png" alt=""></a>
                        <a href="https://www.instagram.com/egoist_original/" target="_blank"><img src="/data/soon/img/instagram-icon.png" alt=""></a>
                    </div>
                </div>
                <div class="section-right clearfix">
                    <img src="/data/soon/img/bg.jpg" alt="">
<!--                    <div><img src="/data/soon/img/mod.jpg" alt=""></div>-->
<!--                    <div><img src="/data/soon/img/mod2.jpg" alt=""></div>-->
<!--                    <div><img src="/data/soon/img/mod3.jpg" alt=""></div>-->
<!--                    <div><img src="/data/soon/img/mod4.jpg" alt=""></div>-->
                </div>

            </div>      <!-- wrap -->
        </section>

        <section class="popup-forms">
            <div class="popup-wait-form popup-sending">            
                <div class="wait-form">
                    <a href="javascript:;" class="">ОЖИДАЙТЕ, ИДЕТ ОБРАБОТКА ДАННЫХ</a>        
                </div><!-- popup-wait-form -->
            </div>          <!-- popup-forms -->

            <div class="popup-wait-form popup-notify">            
                <div class="wait-form">
                    <a href="javascript:;" class="message-wrap"></a>        
                </div><!-- popup-wait-form -->
            </div>          <!-- popup-forms -->


            <div class="popup-success-form">            
                <div class="success-form">
                    <a href="javascript:;" class=""><strong>БЛАГОДАРЮ!</strong><span>Загляни на почту, я и мои стилисты приготовили для тебя что-то особенное.</span></a>        
                </div><!-- popup-wait-form -->
            </div>          <!-- popup-forms -->
        </section>


        <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="/js/vendor/libs.js"></script>
        <script src="/js/main.js"></script>
        <script src="/js/vendor/bootstrap.js"></script>
        <script>

            function popupSendingRequest() {
                $.colorbox({
                  inline: true,
                  href: '.popup-sending',      
                  transition: 'none',
                  overlayClose: false,
                  escKey: false,
                  closeButton: false,
                  onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
                });
            }

            function popupSuccess() {
                $.colorbox({
                  inline: true,
                  href: '.popup-success-form',      
                  transition: 'none',
                  onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
                });
            }

            function notify(message) {
            	$('.popup-notify').find('.message-wrap').text(message);
        		$.colorbox({
                  inline: true,
                  href: '.popup-notify',      
                  transition: 'none',
                  onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
                });
            }

            $("#submit").click("submit", function(event){
                var email = $.trim($('.email').val());
                var phone = $.trim($('.phone-number').val());
                var name = $.trim($('.first-name').val());

                // Check if empty of not
                if (name === '' || email == '' || phone == '') {
                    notify('Не заполнены все поля');
                    return false;
                }

                var reg = /^\d{10}$/;
                var result = phone.match(reg);
                if (result == null) {
                    notify('Укажите телефон в формате 0981234567');
                    return false;
                }

                popupSendingRequest();

                event.preventDefault();
                var form = $("#subscribe");
                $.ajax({
                    url: "soon",
                    type: "POST",
                    data: form.serialize(),
                    success: function (data) {
                    	if (data.success) {
                    		popupSuccess();
                    	} else {
                    		notify(data.message);
                    	}
                    }
                })
            })
        </script>
    </body>
</html>