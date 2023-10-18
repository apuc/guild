<?php

namespace frontend\modules\api\controllers;

use common\models\email\RegistrationEmail;
use common\models\User;
use common\services\EmailService;
use frontend\models\SignupForm;
use Yii;

class RegisterController extends ApiController
{
    public function behaviors()    {
        $newBehavior = parent::behaviors();
        unset($newBehavior['authenticator']);

        return $newBehavior;
    }

    private EmailService $emailService;

    public function __construct($id, $module, EmailService $emailService, $config = [])
    {
        $this->emailService = $emailService;
        parent::__construct($id, $module, $config);
    }

    /**
     *
     * @OA\Post(path="/register/sign-up",
     *   summary="Регистрация",
     *   description="Метод для регистрации",
     *   tags={"Registration"},
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
                $this->emailService->sendEmail(new RegistrationEmail($user));
                return [
                    'id' => $user->id,
                ];
            }
        }

        return null;
    }
}
