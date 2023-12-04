<?php


namespace frontend\modules\api\controllers;

use common\models\User;
use frontend\modules\api\models\profile\forms\ProfileChangeEmailForm;
use frontend\modules\api\models\profile\forms\ProfileChangePersonalDataForm;
use frontend\modules\api\services\UserService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;

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
    }

    private UserService $userService;

    public function __construct(
        $id,
        $module,
        UserService $userService,
        $config = []
    )
    {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
    }

    public function verbs(): array
    {
        return [
            'change-personalData' => ['put', 'patch'],
            'change-email' => ['put', 'patch'],
            'change-password' => ['put', 'patch'],
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     */
    public function actionLogin(): array
    {
        return $this->userService->login(Yii::$app->getRequest()->getBodyParams());
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
     * @return \frontend\modules\api\models\profile\User
     * @throws BadRequestHttpException
     */
    public function actionMe(): \frontend\modules\api\models\profile\User
    {
        return $this->userService->findCurrentUser();
    }

    /**
     *
     * @OA\Put(path="/user/change-email",
     *   summary="Изменить email адрес",
     *   description="Метод для изменения email адреса пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"User"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"newEmail"},
     *          @OA\Property(
     *              property="newEmail",
     *              type="string",
     *              description="Новый email адрес",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *   ),
     * )
     * )
     *
     * @return ProfileChangeEmailForm|string[]
     */
    public function actionChangeEmail()
    {
        return $this->userService->changeEmail(Yii::$app->request->post());
    }

    /**
     *
     * @OA\Put(path="/user/change-password",
     *   summary="Изменить пароль",
     *   description="Метод для изменения пароля пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"User"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"password", "newPassword"},
     *          @OA\Property(
     *              property="password",
     *              type="string",
     *              description="Старый пароль",
     *          ),
     *         @OA\Property(
     *                  property="newPassword",
     *                  type="string",
     *                  description="Новый пароль",
     *              ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *   ),
     * )
     * )
     *
     * @return ProfileChangeEmailForm|string[]
     */
    public function actionChangePassword()
    {
        return $this->userService->changePassword(Yii::$app->request->post());
    }

    /**
     *
     * @OA\Put(path="/user/change-personal-data",
     *   summary="Изменить логин",
     *   description="Метод для изменения логина пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"User"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"newUsername"},
     *          @OA\Property(
     *              property="newUsername",
     *              type="string",
     *              description="Новый логин",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *   ),
     * )
     * )
     *
     * @return ProfileChangePersonalDataForm|string[]
     * @throws \Exception
     */
    public function actionChangePersonalData()
    {
        return $this->userService->changeChangePersonalData(Yii::$app->request->post());
    }
}
