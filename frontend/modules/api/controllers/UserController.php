<?php


namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\models\User;
use frontend\modules\api\models\LoginForm;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class UserController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => GsCors::class,
                'cors' => [
                    'Origin' => ['*'],
                    //'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Headers' => [
                        'Access-Control-Allow-Origin',
                        'Content-Type',
                        'Access-Control-Allow-Headers',
                        'Authorization',
                        'X-Requested-With'
                    ],
                ]
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
    }

//    protected function verbs(){
//        return [
//            'login' => ['POST']
//        ];
//    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return [
                'access_token' => $model->login(),
                'access_token_expired_at' => $model->getUser()->getTokenExpiredAt(),
                'id' => $model->getUser()->id,
                'status' => $model->getUser()->status,
                'card_id' => $model->getUser()->userCard->id ?? null,
            ];
        } else {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }
}
