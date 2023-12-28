<?php

namespace frontend\modules\api\controllers;

use common\models\email\RegistrationEmail;
use common\models\email\ResetPasswordEmail;
use common\models\User;
use common\services\EmailService;
use Exception;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

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
                return $this->asJson([
                    'id' => $user->id,
                ]);
            }
        }

        return $this->asJson(['errors' => $model->errors]);
    }

    /**
     *
     * @OA\Post(path="/register/request-password-reset",
     *   summary="Запросить сброс пароля",
     *   description="Метод метод высылает токен сброса пароля на почтовый адрес",
     *   tags={"Registration"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"email"},
     *          @OA\Property(
     *              property="email",
     *              type="string",
     *              description="Электронная почта пользователя",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает true в случае успеха",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @return bool|string
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post(), '') & $model->validate()) {

            /* @var $user User */
            $user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $model->email,
            ]);

            if (!$user) {
                return false;
            }

            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
                if (!$user->save()) {
                    return false;
                }
            }

            return $this->emailService->sendEmail(new ResetPasswordEmail($user));
        }

        return json_encode($model->getFirstErrors());
    }

    /**
     *
     * @OA\Post(path="/register/reset-password",
     *   summary="Cброс пароля",
     *   description="Метод сброса пароля",
     *   tags={"Registration"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"token", "password"},
     *          @OA\Property(
     *              property="token",
     *              type="string",
     *              description="Токен сброса пароля",
     *          ),
     *          @OA\Property(
     *              property="password",
     *              type="string",
     *              description="Новый пароль пользователя",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @return array|string
     * @throws BadRequestHttpException
     */
    public function actionResetPassword()
    {
        try {
            $model = new ResetPasswordForm(Yii::$app->request->post()['token']);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post(), '') & $model->validate() & $model->resetPassword()) {
            return 'Success! New password saved.';
        } else {
            return $model->errors;
        }
    }
}
