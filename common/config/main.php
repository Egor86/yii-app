<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name'=>'Egoist-me',
    'language' => 'ru-RU',
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'encryption' => '',
            ],
        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect'
        ],
        'cart' => [
            'class' => 'common\components\MyCart',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'ru-RU',
            'timeZone' => 'Europe/Kiev',
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'UAH',
            'nullDisplay' => '',
            'booleanFormat' => ['Нет', 'Да']
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => TRUE,
            'showScriptName' => FALSE,
        ],
        'language'=>'ru-RU',
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
    ],
    'bootstrap' => ['devicedetect'],
];
