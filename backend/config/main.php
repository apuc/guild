<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'ru',
    'bootstrap' => ['log'],

    'modules' => [
        'accesses' => [
            'class' => 'backend\modules\accesses\Accesses',
        ],
        'settings' => [
            'class' => 'backend\modules\settings\Settings',
        ],
        'card' => [
            'class' => 'backend\modules\card\Card',
        ],
        'project' => [
            'class' => 'backend\modules\project\Project',
        ],
        'company' => [
            'class' => 'backend\modules\company\Company',
        ],
        'hh' => [
            'class' => 'backend\modules\hh\Hh',
        ],
        'balance' => [
            'class' => 'backend\modules\balance\Balance',
        ],
        'holiday' => [
            'class' => 'backend\modules\holiday\Holiday',
        ],
        'notes' => [
            'class' => 'backend\modules\notes\Notes',
        ],
        'calendar' => [
            'class' => 'backend\modules\calendar\Calendar',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'reports' => [
            'class' => 'backend\modules\reports\Reports',
        ],
        'options' => [
            'class' => 'backend\modules\options\Options',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/secure',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'rules' => [
                '' => '/card/user-card',
            ],
        ],

    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['site/login', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
