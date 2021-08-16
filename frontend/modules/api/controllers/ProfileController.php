<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\classes\Debug;
use common\models\InterviewRequest;
use frontend\modules\api\models\ProfileSearchForm;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ProfileController extends \yii\rest\Controller
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
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
//            'corsFilter' => [
//                'class' => GsCors::class,
//                'cors' => [
//                    'Origin' => ['https://itguild.info'],
//                    //'Access-Control-Allow-Credentials' => true,
//                    'Access-Control-Allow-Headers' => [
//                        'Content-Type',
//                        'Access-Control-Allow-Headers',
//                        'Authorization',
//                        'X-Requested-With'
//                    ],
//                ]
//            ]
        ];
    }

    public function actionIndex($id = null)
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = \Yii::$app->request->get();

        if ($id) {
            return $searchModel->byId();
        }

        return $searchModel->byParams();
    }

    public function actionAddToInterview()
    {
        if (\Yii::$app->request->isPost) {
            $model = new InterviewRequest();
            $model->attributes = \Yii::$app->request->post();
            $model->created_at = time();
            $model->user_id = \Yii::$app->user->id;
            if ($model->save()){
                return ['status' => 'success'];
            }

            return ['status' => 'error'];
        }
    }

}
