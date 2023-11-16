<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use frontend\modules\api\services\UserQuestionnaireService;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserQuestionnaireController extends ApiController
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'questionnaires-list' => ['get'],
                    'questionnaire-completed' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @OA\Get(path="/user-questionnaire/questionnaires-list",
     *   summary="Список тестов",
     *   description="Получение списка тестов",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов тест",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserQuestionnaireArrExample"),
     *     ),
     *   ),
     *
     *   ),
     * )
     *
     * @throws NotFoundHttpException
     */
    public function actionQuestionnairesList($user_id): array
    {
        if (empty($user_id) or !is_numeric($user_id)) {
            throw new NotFoundHttpException('Incorrect user ID');
        }
        $userQuestionnaireModels = UserQuestionnaireService::getQuestionnaireList($user_id);
        if(empty($userQuestionnaireModels)) {
            throw new NotFoundHttpException('Active questionnaire not found');
        }
        return $userQuestionnaireModels;
    }

    /**
     * @OA\Get(path="/user-questionnaire/questionnaire-completed",
     *   summary="Проверка теста",
     *   description="Выполнение проверки теста",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="user_questionnaire_uuid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/UserQuestionnaireExample"),
     *     ),
     *
     *   ),
     * )
     *
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException|InvalidConfigException
     */
    public function actionQuestionnaireCompleted($user_questionnaire_uuid): UserQuestionnaire
    {
        $userQuestionnaireModel = UserQuestionnaireService::calculateScore($user_questionnaire_uuid);
        if ($userQuestionnaireModel->errors) {
            throw new ServerErrorHttpException($userQuestionnaireModel->errors);
        }
        return $userQuestionnaireModel;
    }
}
