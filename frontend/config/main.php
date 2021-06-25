<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Guild',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Api',
        ],
        'access' => [
            'class' => 'frontend\modules\access\Access',
        ],
        'card' => [
            'class' => 'frontend\modules\card\Card',
        ],
        'reports' => [
            'class' => 'frontend\modules\reports\Reports',
        ],
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
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
            'rules' => [
                'site/index' => 'card/user-card/index',
                'api/profile/<id:\d+>' => 'api/profile/index',
                '' => 'card/user-card/index',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'skills'],
            ],
        ],

    ],
    'params' => $params,
];