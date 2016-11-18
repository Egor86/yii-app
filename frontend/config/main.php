<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
//                '/' => '/subscriber/soon',
                [
                    'pattern' => 'soon',
                    'route' => '/subscriber/soon',
                    'suffix' => ''
                ],
                'cart' => '/cart/view',
                [
                    'pattern' => 'page/<slug:[A-Za-z-]+>',
                    'route' => 'page/view',
                    'encodeParams' => false,
                ],
                [
                    'pattern' => '<slug:[A-Za-z-]+>/',
                    'route' => 'category/filter',
                    'mode' => 'PARSING_ONLY',
//                    'encodeParams' => false,
                    'suffix' => ''
                ],
                [
                    'pattern' => '<slug:[A-Za-z-]+>',
                    'route' => 'category/view',
                    'encodeParams' => false,
                    'suffix' => '/'
                ],
                '<slug>' => 'item/view',
            ],
        ],
    ],
    'params' => $params,
];
