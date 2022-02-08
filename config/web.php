<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'GGcIL7R0s9Tic8IFtv_BTl2kiMbS2nuY',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // TODO: refactor this
                'backend' => 'backend/backend/index',
                'backend/' => 'backend/backend/index',
                'backend/index' => 'backend/backend/index',
                'backend/home' => 'backend/backend/index',
                'backend/bookings' => 'backend/backend/bookings',
                'backend/booking' => 'backend/backend/bookings',
                'backend/backend/booking' => 'backend/backend/bookings',
                'backend/calendar' => 'backend/backend/calendar',
                'backend/holidays' => 'backend/backend/holidays',
                'backend/holiday' => 'backend/backend/holidays',
                'backend/backend/holiday' => 'backend/backend/holidays',
                'backend/roles' => 'backend/backend/roles',
                'backend/role' => 'backend/backend/roles',
                'backend/backend/role' => 'backend/backend/roles',

                'booking' => 'booking/booking/index'
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'booking' => [
            'class' => 'app\modules\booking\Booking'
        ],
        'backend' => [
            'class' => 'app\modules\backend\Backend'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
