<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\models\Options;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class SkillsController extends ApiController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $b = [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
        ];

        return array_merge($parent, $b);
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
