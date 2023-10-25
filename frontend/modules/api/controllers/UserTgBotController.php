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
     * @OA\Get(path="/tg-bot/token",
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
     * @OA\Get(path="/tg-bot/user",
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
     * @OA\Post(path="/tg-bot/dialog/create",
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
     * @OA\Get(path="/tg-bot/dialog/dialog/id",
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
    public function actionGetDialogIdByUserId(string $userId): array
    {
        return $this->userTgBotTokenService->getDialogIdByUserId($userId);
    }

    /**
     *
     * @OA\Get(path="/tg-bot/dialog/user/id",
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
    public function actionGetUserIdByDialogId(string $dialogId): array
    {
        return $this->userTgBotTokenService->getUserIdByDialogId($dialogId);
    }
}
