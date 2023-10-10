<?php

namespace frontend\modules\api\controllers;

use common\models\UserResponse;
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
     * @OA\Post(path="/user-response/set-response",
     *   summary="Добавить ответ пользователя",
     *   description="Добавление ответа на вопрос от пользователя",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *     description="ID пользователя",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="question_id",
     *      in="query",
     *      required=true,
     *     description="ID вопроса",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="response_body",
     *      in="query",
     *      required=true,
     *     description="Ответ пользователя",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="user_questionnaire_uuid",
     *      in="query",
     *      required=true,
     *     description="UUID анкеты назначенной пользователю",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает ответ",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserResponseExample"),
     *     ),
     *   ),
     * )
     *
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException|BadRequestHttpException
     */
    public function actionSetResponse(): UserResponse
    {
        $userResponseModel = UserResponseService::createUserResponse(Yii::$app->getRequest()->getBodyParams());
        if ($userResponseModel->errors) {
            throw new ServerErrorHttpException(json_encode($userResponseModel->errors));
        }
        return $userResponseModel;
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
