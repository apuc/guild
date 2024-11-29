<?php


namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\UserTgBotDialog as UserTgBotDialogAlias;
use Exception;
use frontend\modules\api\models\profile\User;
use frontend\modules\api\models\tg_bot\forms\TgBotDialogForm;
use frontend\modules\api\models\tg_bot\UserTgBotDialog;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use frontend\modules\api\services\UserTgBotService;
use frontend\modules\api\services\UserTgBotTokenService;
use Yii;
use yii\web\BadRequestHttpException;

class UserTgBotController extends ApiController
{
    /**
     * @var UserTgBotTokenService
     */
    private UserTgBotTokenService $userTgBotTokenService;
    private UserTgBotService $botService;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if ($this->action->id == "auth") {
            unset($behaviors['authenticator']);
        }

        return $behaviors;
    }

    public function __construct(
        $id,
        $module,
        UserTgBotTokenService $userTgBotTokenService,
        $config = []
    )
    {
        $this->userTgBotTokenService = $userTgBotTokenService;
        $this->botService = new UserTgBotService();
        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Get(path="/user-tg-bot/get-token",
     *   summary="Токен ТГ бота",
     *   description="Метод для возвращает токен для ТГ бота",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект токен ТГ бота",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserTgBotTokenExample"),
     *     ),
     *   ),
     * )
     *
     * @return UserTgBotToken
     * @throws Exception
     */
    public function actionGetToken(): UserTgBotToken
    {
        return $this->userTgBotTokenService->getToken(Yii::$app->user->id);
    }

    /**
     *
     * @OA\Get(path="/user-tg-bot/get-user",
     *   summary="Получить данные пользователя",
     *   description="Метод для получения данныех пользователя по токену ТГ бота",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="token",
     *      in="query",
     *      example="HDAS7J",
     *      required=true,
     *      description="Токен ТГ бота",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает данные пользователя",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @param string $token
     * @return User|string[]
     * @throws Exception
     */
    public function actionGetUser(string $token): array|User
    {
        return $this->userTgBotTokenService->getUserByToken($token);
    }

    /**
     *
     * @OA\Post(path="/user-tg-bot/set-dialog",
     *   summary="Сохранить новый id диалога",
     *   description="Метод создает новую запись с id пользователя и id диалога",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"dialog_id"},
     *          @OA\Property(
     *              property="dialog_id",
     *              type="integer",
     *              description="id диалога",
     *          ),
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="id пользователя",
     *          ),
     *          @OA\Property(
     *               property="username",
     *               type="string",
     *               description="TG username",
     *          ),
     *          @OA\Property(
     *                property="first_name",
     *                type="string",
     *                description="TG first_name",
     *          ),
     *          @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="TG last_name",
     *          ),
     *          @OA\Property(
     *                  property="key_words",
     *                  type="string",
     *                  description="Ключевые слова",
     *          ),
     *          @OA\Property(
     *                   property="status",
     *                   type="integer",
     *                   description="Статус",
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
     * @return array|UserTgBotDialog|TgBotDialogForm
     * @throws \yii\db\Exception
     */
    public function actionSetDialog(): array|UserTgBotDialog|TgBotDialogForm
    {
        return $this->userTgBotTokenService->createDialog(Yii::$app->request->post());
    }

    /**
     *
     * @OA\Get(path="/user-tg-bot/dialog/get-dialog-id",
     *   summary="Получить id диалога по id пользователя",
     *   description="Метод для получения id пользователя по id пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="userId",
     *      in="query",
     *      example="1",
     *      required=true,
     *      description="id пользователя",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает dialog_id",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @param string $userId
     * @return array
     * @throws Exception
     */
    public function actionGetDialogId(string $userId): array
    {
        return $this->userTgBotTokenService->getDialogIdByUserId($userId);
    }

    /**
     *
     * @OA\Get(path="/user-tg-bot/get-dialog",
     *   summary="Получить диалог по id",
     *   description="Метод для получения диалога по id",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="dialog_id",
     *      in="query",
     *      example="134576",
     *      required=true,
     *      description="id диалога",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает диалог",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @param int $dialog_id
     * @return UserTgBotDialog
     * @throws Exception
     */
    public function actionGetDialog(int $dialog_id): UserTgBotDialog
    {
        return $this->userTgBotTokenService->getDialogById($dialog_id);
    }

    /**
     *
     * @OA\Post(path="/user-tg-bot/set-user-at-dialog",
     *   summary="Установить пользователя в диалог",
     *   description="Метод для установления пользователя в диалог",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *        mediaType="multipart/form-data",
     *        @OA\Schema(
     *           required={"dialog_id", "user_id"},
     *           @OA\Property(
     *               property="dialog_id",
     *               type="integer",
     *               description="id диалога",
     *           ),
     *           @OA\Property(
     *               property="user_id",
     *               type="integer",
     *               description="id пользователя",
     *           ),
     *        ),
     *      ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает диалог",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @return UserTgBotDialog|array
     * @throws \yii\db\Exception
     */
    public function actionSetUserAtDialog(): UserTgBotDialog|array
    {
        $request = \Yii::$app->request->post();

        $request = array_diff($request, [null, '']);

        return $this->userTgBotTokenService->setUserAtDialog($request['dialog_id'], $request['user_id']);
    }

    /**
     *
     * @OA\Get(path="/user-tg-bot/get-user-id",
     *   summary="Получить id пользователя по id диалога",
     *   description="Метод для получения id пользователя по id диалога",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="dialogId",
     *      in="query",
     *      example="225",
     *      required=true,
     *      description="id диалога",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает user_id",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @param string $dialogId
     * @return array
     * @throws Exception
     */
    public function actionGetUserId(string $dialogId): array
    {
        return $this->userTgBotTokenService->getUserIdByDialogId($dialogId);
    }

    /**
     *
     * @OA\Post(path="/user-tg-bot/auth",
     *   summary="Аутентификация",
     *   description="Метод производит аутентификацию пользователя по токену ТГ бта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="token",
     *      in="query",
     *      example="1",
     *      required=true,
     *      description="токен пользователя",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает сообщение об успехе",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *          *     @OA\Schema(
     *     schema="schemae_5cfb24156100e_category",
     *          @OA\Property(property="access_token",type="string",description="Category ID",example="HclquHysW2Y6LecQfM_ZZTjL4kBz-jOi"),
     *          @OA\Property(property="access_token_expired_at",type="dateTime",description="Expired at",example="2023-11-08"),
     *          @OA\Property(property="id",type="integer",description="ID",example=1),
     *          @OA\Property(property="status",type="integer",description="status",example=1),
     *          @OA\Property(property="card_id",type="integer",description="Card ID",example=1),
     *      ),
     *     ),
     *   ),
     * )
     *
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionAuth(): array
    {
        return $this->userTgBotTokenService->auth(Yii::$app->request->post());
    }

    /**
     *
     * @OA\Get(path="/user-tg-bot/get-dialog-by-status",
     *   summary="Получить пользователя по статусу диалога",
     *   description="Метод для получения пользователя по статусу диалога",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TgBot"},
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      example="2",
     *      required=true,
     *      description="Статус",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает диалог",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *   ),
     * )
     *
     * @param integer $status
     * @throws Exception
     */
    public function actionGetDialogByStatus(int $status): \yii\data\ActiveDataProvider
    {
        return $this->botService->getDialogsByStatus($status);
    }

    public function actionGetAdmins(): array
    {
        return UserTgBotDialog::find()->where(["status" => [UserTgBotDialogAlias::STATUS_ADMIN, UserTgBotDialogAlias::STATUS_EXPERT]])->all();
    }

    public function actionGetAll(): array
    {
        return UserTgBotDialog::find()->all();
    }

    public function actionCreateAnonymousDialog()
    {

    }
}
