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
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'common\models\User'
            ]
        ],
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ],
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
        'interview' => [
            'class' => 'backend\modules\interview\Interview',
        ],
        'achievements' => [
            'class' => 'backend\modules\achievements\Achievements',
        ],
        'test' => [
            'class' => 'backend\modules\test\Test',
        ],
        'questionnaire' => [
            'class' => 'backend\modules\questionnaire\Questionnaire',
        ],
        'employee' => [
            'class' => 'backend\modules\employee\Employee',
        ],
        'task' => [
            'class' => 'backend\modules\task\Task',
        ],
        'document' => [
            'class' => 'backend\modules\document\Document',
        ],
        'help' => [
            'class' => 'backend\modules\help\Help',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/secure',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/xml' => 'yii/web/XmlParser',
            ],
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
//            'enableSession' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
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
//                'api/user-questionnaire/<id:\d+>' => 'api/profile/user-questionnaire',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user-questionnaire',
                    'except' => ['delete', 'update'],
                ],
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
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
