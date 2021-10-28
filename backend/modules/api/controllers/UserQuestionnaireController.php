<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class UserQuestionnaireController extends Controller
{
    public $modelClass = 'backend/modules/api/models/UserQuestionnaire';


    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
//            'authenticator' => [
//                'class' => CompositeAuth::class,
//                'authMethods' => [
//                    HttpBearerAuth::class,
//                ],
//            ]
        ];
    }

    public function actionIndex()
    {
        return ['some' => 'rrr'];
    }

//    /**
//     * @inheritdoc
//     */
//    protected function verbs()
//    {
//        return [
//            'index' => ['GET', 'HEAD'],
//        ];
//    }



}
