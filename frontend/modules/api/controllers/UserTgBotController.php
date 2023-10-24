<?php


namespace frontend\modules\api\controllers;

use Exception;
use frontend\modules\api\models\profile\User;
use frontend\modules\api\models\UserTgBotToken;
use frontend\modules\api\services\UserTgBotTokenService;
use Yii;
use yii\helpers\ArrayHelper;

class UserTgBotController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'get-token' => ['get'],
                    'get-user-by-token' => ['get'],
                ],
            ]
        ]);
    }

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
     * @OA\Get(path="/user-tg-bot/get-token",
     *   summary="Токен ТГ бота",
     *   description="Метод для возвращает токен для ТГ бота",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"UserTgBotToken"},
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
    public function actionGetToken()
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
     *   tags={"UserTgBotToken"},
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
}
