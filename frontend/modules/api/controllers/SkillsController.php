<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\models\Options;
use yii\filters\AccessControl;

class SkillsController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => GsCors::class,
                'cors' => [
                    'Origin' => ['*'],
                    //'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Headers' => [
                        'Content-Type',
                        'Access-Control-Allow-Headers',
                        'Authorization',
                        'X-Requested-With'
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return ['some' => 'rrr'];
    }

    public function actionSkillsOnMainPage()
    {
        $data = \common\models\Options::getValue('skills_on_main_page_to_front');
        if ($data) $data = json_decode($data, true);
        else return [];

        return $data;
    }

}
