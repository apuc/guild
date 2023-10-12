<?php


namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\classes\Debug;
use common\models\User;
use frontend\modules\api\models\LoginForm;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class UserController extends ApiController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if($this->action->id == "login"){
            unset($behaviors['authenticator']);
        }

        return $behaviors;
//        return ArrayHelper::merge(parent::behaviors(), [
//            [
//                'class' => ContentNegotiator::class,
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                ],
//            ],
//            'corsFilter' => [
//                'class' => GsCors::class,
//                'cors' => [
//                    'Origin' => ['*'],
//                    //'Access-Control-Allow-Credentials' => true,
//                    'Access-Control-Allow-Headers' => [
//                        'Access-Control-Allow-Origin',
//                        'Content-Type',
//                        'Access-Control-Allow-Headers',
//                        'Authorization',
//                        'X-Requested-With'
//                    ],
//                ]
//            ],
//        ]);
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
            /** @var User $user */
            $user = $model->getUser();
            return [
                'access_token' => $model->login(),
                'access_token_expired_at' => $model->getUser()->getTokenExpiredAt(),
                'id' => $user->id,
                'status' => $user->userCard->status ?? null,
                'card_id' => $user->userCard->id ?? null,
            ];
        } else {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }

    /**
     *
     * @OA\Get(path="/user/me",
     *   summary="Получить данные пользователя",
     *   description="Метод для получения данныех пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"User"},
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает данные пользователя",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @return \frontend\modules\api\models\User
     * @throws BadRequestHttpException
     */
    public function actionMe(): \frontend\modules\api\models\User
    {
        $user = \frontend\modules\api\models\User::findOne(Yii::$app->user->id);
        if (!$user){
            throw new BadRequestHttpException("User not found");
        }

        return $user;
    }
}
