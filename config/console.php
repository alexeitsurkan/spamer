<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'modules'             => [
        'cron_manager'     => [
            'class' => app\commands\modules\cron_manager\CronManager::class,
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'                => [
            'traceLevel' => 3,
            'targets'    => [
                'db'       => [
                    'class'          => yii\log\DbTarget::class,
                    'levels'         => ['error', 'info', 'warning'],
                    'exportInterval' => 2,
                    'except'         => [
                        'yii\web\HttpException:404',
                        'yii\db\Command::execute',
                        'yii\db\Command::query',
                        'yii\web\Session::open',
                        'yii\db\Connection::open',
                        'application',
                    ],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
