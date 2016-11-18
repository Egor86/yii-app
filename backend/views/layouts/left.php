<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
<!--        <div class="user-panel">-->
<!--            <div class="pull-left image">-->
<!--                <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
<!--            </div>-->
<!--            <div class="pull-left info">-->
<!--                <p>Alexander Piercedddd</p>-->
<!---->
<!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
<!--            </div>-->
<!--        </div>-->

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Admin Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'url' => ['/']],
//                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'fa fa-share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'fa fa-circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'fa fa-circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                    ['label' => 'Заказы', 'icon' => 'fa fa-share', 'url' => '#',
                        'items' => [
                            ['label' => 'Заказы в работе', 'icon' => 'fa fa-shopping-cart', 'url' => ['order/index'],],
                            ['label' => 'Пред-заказы', 'icon' => 'fa fa-pause', 'url' => ['pre-order/index'],],
                            ['label' => 'Архив', 'icon' => 'fa fa-archive', 'url' => ['order/archive'],]
                        ]
                    ],
                    ['label' => 'Продукты', 'icon' => 'fa fa-flag', 'url' => ['product/']],
                    ['label' => 'Товары', 'icon' => 'fa fa-flag', 'url' => ['item/']],
                    ['label' => 'Категории продуктов', 'icon' => 'fa fa-flag-o', 'url' => ['category/']],
                    ['label' => 'Акции', 'icon' => 'fa fa-circle-o', 'url' => ['campaign/']],
                    ['label' => 'Доступные цвета', 'icon' => 'fa fa-file-image-o', 'url' => ['color/']],
                    ['label' => 'Подписчики', 'icon' => 'fa fa-users', 'url' => ['subscriber/']],
                    ['label' => 'Статические страницы', 'icon' => 'fa fa-th-list', 'url' => ['page/']],
                    ['label' => 'Размеры', 'icon' => 'fa fa-circle-o', 'url' => ['size/']],
                    ['label' => 'Комментарии пользователей', 'icon' => 'fa fa-comment', 'url' => ['comment/']]
                ],
            ]
        ) ?>

    </section>
</aside>
