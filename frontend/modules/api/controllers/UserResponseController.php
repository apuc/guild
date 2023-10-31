<?php

namespace frontend\modules\api\controllers;

use common\services\UserResponseService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseController extends ApiController
{
    public function verbs(): array
    {
        return [
            'set-response' => ['post'],
            'set-responses' => ['post'],
        ];
    }

    /**
     * @OA\Post(path="/user-response/set-responses",
     *   summary="Добавить массив ответов пользователя",
     *   description="Добавление массива ответов на вопросы от пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"request_id"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="question_id",
     *              type="integer",
     *              description="Идентификатор вопроса",
     *          ),
     *          @OA\Property(
     *              property="response_body",
     *              type="string",
     *              description="UUID анкеты назначенной пользователю",
     *          ),
     *          @OA\Property(
     *              property="user_questionnaire_uuid",
     *              type="string",
     *              description="UUID анкеты назначенной пользователю",
     *          ),
     *       ),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserResponseExampleArr"),
     *     ),
     *   ),
     * )
     *
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException|BadRequestHttpException
     */
    public function actionSetResponses(): array
    {
        $userResponseModels = UserResponseService::createUserResponses(Yii::$app->getRequest()->getBodyParams());
        foreach ($userResponseModels as $model) {
            if ($model->errors) {
                throw new ServerErrorHttpException(json_encode($model->errors));
            }
        }
        return $userResponseModels;
    }
}
