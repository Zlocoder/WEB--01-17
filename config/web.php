<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__) . '/application',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => dirname(__DIR__) . './runtime',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'errorHandler' => [
            'errorView' => '@yiister/adminlte/views/error.php'
        ],
        'request' => [
            'cookieValidationKey' => 'ebBJzOwQYrLmkX3GnEl8lU5qcPw3MjJD',
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login'],
            'permissions' => require __DIR__ . '/permissions.php'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'dev.george.lemish@gmail.com', //xxxx@gmail.com
                'password' => 'kaskad13',
                'port' => '587',
                'encryption' => 'tls',
            ]
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'forceCopy' => true
        ]
    ],
    'defaultRoute' => 'dashboard/index',
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'adminMainFrame' => [
                'class' => 'yii2tech\admin\gii\mainframe\Generator'
            ],
            'adminCrud' => [
                'class' => 'yii2tech\admin\gii\crud\Generator'
            ]
        ]
    ];
}

return $config;
