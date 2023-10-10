<?php

namespace frontend\modules\api\controllers;

use common\services\UserQuestionnaireService;
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
                    'get-points-number' => ['get'],
                    'get-question-number' => ['get'],
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
     *   description="Выполнения проверки теста",
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
     * @throws ServerErrorHttpException
     */
    public function actionQuestionnaireCompleted($user_questionnaire_uuid)
    {
        $userQuestionnaireModel = UserQuestionnaireService::calculateScore($user_questionnaire_uuid);
        if ($userQuestionnaireModel->errors) {
            throw new ServerErrorHttpException($userQuestionnaireModel->errors);
        }
        return $userQuestionnaireModel;
    }

    /**
     * @OA\Get(path="/user-questionnaire/get-points-number",
     *   summary="Количество балов в тесте",
     *   description="Возвращает максимальное количество балов за тест",
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
     *     description="Возвращает максимально возможное количество балов за тест",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                     property="sum_point",
     *                     type="integer",
     *                     example="61",
     *                 ),
     *         ),
     *     ),
     *
     *   ),
     * )
     * @throws ServerErrorHttpException
     */
    public function actionGetPointsNumber($user_questionnaire_uuid)
    {
        $questionPointsNumber = UserQuestionnaireService::getPointsNumber($user_questionnaire_uuid);
        if (empty($questionPointsNumber)) {
            throw new ServerErrorHttpException('Question points not found!');
        }
        return $questionPointsNumber;
    }

    /**
     * @OA\Get(path="/user-questionnaire/get-question-number",
     *   summary="Число вопросов в тесте",
     *   description="Возвращает число вопросов в тесте",
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
     *     description="Возвращает число вопросов в тесте",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                     property="question_number",
     *                     type="integer",
     *                     example="61",
     *                 ),
     *         ),
     *     ),
     *
     *   ),
     * )
     * @throws ServerErrorHttpException
     */
    public function actionGetQuestionNumber($user_questionnaire_uuid)
    {
        $questionNumber = UserQuestionnaireService::getQuestionNumber($user_questionnaire_uuid);
        if (empty($questionNumber)) {
            throw new ServerErrorHttpException('Question number not found!');
        }
        return $questionNumber;
    }
}
