<?php


namespace frontend\modules\api\controllers;

use Exception;
use frontend\modules\api\models\profile\User;
use frontend\modules\api\models\tg_bot\forms\TgBotDialogForm;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use frontend\modules\api\services\UserTgBotTokenService;
use Yii;

class UserTgBotController extends ApiController
{
    /**
     * @var UserTgBotTokenService
     */
    private UserTgBotTokenService $userTgBotTokenService;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if($this->action->id == "auth"){
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
    public function actionGetUser(string $token)
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
     *   @OA\Parameter(
     *      name="dialogId",
     *      in="query",
     *      example="2355",
     *      required=true,
     *      description="id диалога",
     *      @OA\Schema(
     *        type="integer",
     *      )
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
     * @return TgBotDialogForm|string[]
     * @throws Exception
     */
    public function actionSetDialog()
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
    public function actionAuth()
    {
        return $this->userTgBotTokenService->auth(Yii::$app->request->post());
    }
}
