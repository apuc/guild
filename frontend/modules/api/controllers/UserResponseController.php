<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use frontend\modules\api\services\UserQuestionnaireService;
use frontend\modules\api\services\UserResponseService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseController extends ApiController
{
    private UserQuestionnaireService $userQuestionnaireService;

    public function __construct(
        $id,
        $module,
        UserQuestionnaireService $userQuestionnaireService,
        $config = []
    )
    {
        $this->userQuestionnaireService = $userQuestionnaireService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Post(path="/user-response/set-responses",
     *   summary="Добавить массив ответов пользователя",
     *   description="Добавление массива ответов на вопросы от пользователя. При наличии лимита времени на выполнение теста,
         будет проведена проверка. При превышении лимита времени на выполнение будет возвращена ошибка: Time's up!",
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
     *     description="Возвращает масив ответов",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserResponseExampleArr"),
     *     ),
     *   ),
     * )
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSetResponses(): array
    {
        $uuid = Yii::$app->request->post('user_questionnaire_uuid');
        $userResponses = Yii::$app->request->post('userResponses');

        $userQuestionnaire = UserQuestionnaire::findOne(['uuid' => $uuid]);

        if (!$this->userQuestionnaireService->checkTimeLimit($userQuestionnaire)) {
            UserQuestionnaireService::calculateScore($userQuestionnaire->uuid);
            throw new BadRequestHttpException("Time's up!");
        }

        $userResponseModels = UserResponseService::createUserResponses($userResponses,  $uuid);
        foreach ($userResponseModels as $model) {
            if ($model->errors) {
                throw new ServerErrorHttpException(json_encode($model->errors));
            }
        }
        return $userResponseModels;
    }
}
