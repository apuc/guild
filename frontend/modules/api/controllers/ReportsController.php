<?php

namespace frontend\modules\api\controllers;

use common\models\Reports;
use common\models\ReportsTask;
use common\models\UserCard;
use DateTime;
use frontend\modules\api\models\ReportSearchForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ReportsController extends ApiController
{
    /**
     * @OA\Get(path="/user-response/index",
     *   summary="Поиск отчётов по промежутку дат",
     *   description="Осуществляет поиск отчётов пользователя по промежутку дат",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"user_card_id"},
     *          @OA\Property(
     *              property="user_card_id",
     *              type="integer",
     *              description="Идентификатор карты(профиля) пользователя",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="fromDate",
     *              type="DateTime",
     *              description="Дата начала поиска",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="toDate",
     *              type="DateTime",
     *              description="Дата конца периода поиска",
     *              nullable=false,
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
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseExample"),
     *     ),
     *   ),
     *
     *
     * )
     *
     * @param $user_card_id
     * @return array
     */
    public function actionIndex($user_card_id): array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        $reportsModel->attributes = $params;

        $reportsModel->limit = $params['limit'] ?? $reportsModel->limit;
        $reportsModel->offset = $params['offset'] ?? $reportsModel->offset;

        if(!$reportsModel->validate()){
            return $reportsModel->errors;
        }

        return  $reportsModel->byParams();
    }

    /**
     * @OA\Get(path="/user-response/find-by-date",
     *   summary="Поиск отчётов по дате",
     *   description="Осуществляет поиск отчётов пользователя по дате",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"user_card_id"},
     *          @OA\Property(
     *              property="user_card_id",
     *              type="integer",
     *              description="Идентификатор карты(профиля) пользователя",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="date",
     *              type="DateTime",
     *              description="Дата поиска",
     *              nullable=false,
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
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseExample"),
     *     ),
     *   ),
     *
     *
     * )
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionFindByDate(): array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        if(!isset($params['user_card_id']) or !isset($params['date'])){
            throw new NotFoundHttpException('Required parameter are missing!');
        }

        $reportsModel->attributes = $params;
        $reportsModel->date = $params['date'];

        if (!$this->checkDate($reportsModel->date)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        if(!$reportsModel->validate()){
            return $reportsModel->errors;
        }

        return $reportsModel->findByDate();
    }

    /**
     * @OA\Post(path="/reports/create",
     *   summary="Создание отчёта",
     *   description="Метод для создания нового отчёта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *     name="difficulties",
     *     in="query",
     *     required=false,
     *     description="Описание сложностей возникших при выполнении задач",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="tomorrow",
     *     in="query",
     *     required=false,
     *     description="Описание планов на завтра",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="created_at",
     *     in="query",
     *     required=false,
     *     description="Дата создания",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="status",
     *     in="query",
     *     required=false,
     *     description="Статус",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="user_card_id",
     *     in="query",
     *     required=false,
     *     description="ID карты(профиля) пользователя",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="project_id",
     *     in="query",
     *     required=false,
     *     description="ID проекта",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="company_id",
     *     in="query",
     *     required=false,
     *     description="ID компании",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="tasks[]",
     *     in="query",
     *     required=false,
     *     description="Масив задач. ",
     *     @OA\Schema(
     *          type="array",
     *          @OA\Items(
     *                  type="object",
     *                  @OA\Property(
     *                      property="task",
     *                      description="Название задачи",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="hours_spent",
     *                      description="Затраченное количество часов",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="minutes_spent",
     *                      description="Затраченное количество минут",
     *                      type="string",
     *                  )
     *              )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseCreateExample"),
     *     ),
     *   ),
     *     )
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionCreate(): array
    {
        $params = Yii::$app->request->post();
        if (!isset($params['tasks'])){
            throw new BadRequestHttpException('Нет параметра tasks');
        }

        if(!isset($params['user_card_id'])){
            $userCard = UserCard::find()->where(['id_user' => Yii::$app->user->id])->one();
            if($userCard){
                $params['user_card_id'] = $userCard->id;
            }
        }

        $reportsModel = new Reports();
        $reportsModel->attributes = $params;
        if(!$reportsModel->validate() || !$reportsModel->save()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $tasks = $params['tasks'];
        foreach ($tasks as $task) {
            $reportsTask = new ReportsTask();
            $reportsTask->attributes = $task;
            $reportsTask->report_id = $reportsModel->id;
            $reportsTask->created_at = $reportsTask->created_at ?? strtotime($reportsModel->created_at);
            $reportsTask->status = $reportsTask->status ?? 1;

            if(!$reportsTask->validate() || !$reportsTask->save()){
                throw new BadRequestHttpException(json_encode($reportsTask->errors));
            }
        }

        return array_merge($reportsModel->toArray());
    }


    /**
     * @OA\Get(path="/user-response/delete",
     *   summary="Удаление отчёта",
     *   description="Осуществляет удаление отчёта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"id"},
     *          @OA\Property(
     *              property="id",
     *              type="integer",
     *              description="Идентификатор отчётая",
     *              nullable=false,
     *          ),
     *       ),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает true в случае успеха",
     *   ),
     * )
     *
     * @return bool
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $report = Reports::findOne($id);

        if(null === $report) {
            throw new NotFoundHttpException('Report not found');
        }

        if(false === ($report->delete())) {
            throw new \RuntimeException('Report not deleted');
        }

        return true;
    }

    /**
     * @OA\Get(path="/reports/update",
     *   summary="Обновление отчёта",
     *   description="Метод для Обновления отчёта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *     name="id",
     *     in="query",
     *     required=true,
     *     description="ID отчёта",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="created_at",
     *     in="query",
     *     required=false,
     *     description="Дата создания (yyyy-mm-dd)",
     *     @OA\Schema(
     *       type="DateTime",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="today",
     *     in="query",
     *     required=false,
     *     description="Сделанное сегодня",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="difficulties",
     *     in="query",
     *     required=false,
     *     description="Описание сложностей возникших при выполнении задач",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="tomorrow",
     *     in="query",
     *     required=false,
     *     description="Описание планов на завтра",
     *     @OA\Schema(
     *       type="string",
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="status",
     *     in="query",
     *     required=false,
     *     description="Статус",
     *     @OA\Schema(
     *       type="integer",
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseCreateExample"),
     *     ),
     *   ),
     *     )
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): array
    {
        $params = Yii::$app->request->get();

        $reportsModel = Reports::findone($params['id']);
        if(!isset($reportsModel)) {
            throw new NotFoundHttpException('report not found');
        }

        if(isset($params['user_card_id'])) {
            throw new \RuntimeException('constraint by user_card_id');
        }

        $reportsModel->attributes = $params;

        if(!$reportsModel->validate()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $reportsModel->save();

        return $reportsModel->toArray();
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $user_card_id
     * @return array|array[]|object|object[]|string[]
     * @throws BadRequestHttpException
     */
    public function actionReportsByDate($fromDate, $toDate, $user_card_id)
    {
        if (!$this->checkDate($fromDate) || !$this->checkDate($toDate)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        $params = Yii::$app->request->get();

        $reportsModel = new ReportSearchForm();
        $reportsModel->attributes = $params;
        $reportsModel->user_card_id = $user_card_id;

        $reports = $reportsModel->reportsByDate();
        return ArrayHelper::toArray($reports , [
            'common\models\Reports' => [
                'date' => 'created_at',
                'id',
                'spendTime' => function (Reports $report) {
                    return $report->calculateOrderTime();
                },
            ],
        ]);
    }

    private function checkDate($date): bool
    {
        $checkedDate = DateTime::createFromFormat('Y-m-d', $date);
        $date_errors = DateTime::getLastErrors();
        if (!empty($date_errors['warning_count']) || !empty($date_errors['error_count'])) {
            return false;
        }
        return true;
    }
}
