<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\User;
use frontend\models\SignupForm;
use Yii;

class RegisterController extends ApiController
{
    public function behaviors()    {
        $newBehavior = parent::behaviors();
        unset($newBehavior['authenticator']);

        return $newBehavior;
    }

    /**
     *
     * @OA\Post(path="/register/sign-up",
     *   summary="Регистрация",
     *   description="Метод для регистрации",
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"username", "email", "password"},
     *          @OA\Property(
     *              property="username",
     *              type="string",
     *              description="Имя пользрователя",
     *          ),
     *          @OA\Property(
     *              property="email",
     *              type="string",
     *              description="Электронная почта пользователя",
     *          ),
     *          @OA\Property(
     *              property="password",
     *              type="string",
     *              description="Пароль пользователя",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает идентификатор пользователя",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     */
    public function actionSignUp()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            /** @var User $user */
            if ($user = $model->signup()) {
                return [
                    'id' => $user->id,
                ];
            }
        }

        return null;
    }
}
