<?php

use common\behaviors\GsCors;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'itGuild',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    'modules' => [
        'api' => [
            'components' => [
                'user' => [
                    'identityClass' => 'frontend\modules\api\models\profile\User',
                    'enableAutoLogin' => true,
                    'enableSession' => false,
                    'class' => 'frontend\modules\api\models\profile\User',
                    //'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
                ],
            ],
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
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ],
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
                'api/reports/<id:\d+>' => 'api/reports/view',
                '' => 'card/user-card/index',

                ['class' => 'yii\rest\UrlRule', 'controller' => 'skills'],
            ],
        ],
        'telegram_bot' => [
            'class' => 'kavalar\TelegramBotApi',
            'templates' => [
                'interview_request'  =>
                      "Пришёл запрос на интервью.\n".
                      "Профиль: ~profile_id~\n".
                      "Телефон: ~phone~\n".
                      "Email: ~email~\n".
                      "Комментарий: ~comment~"
            ],
            'telegramBotToken' => $params['telegramBotToken'],
            'telegramChatId' => $params['telegramBotChatId'],
        ],

    ],
    'params' => $params,
];