<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\Reports;
use common\models\ReportsTask;
use common\models\UserCard;
use DateTime;
use frontend\modules\api\models\ReportSearchForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ReportsController extends ApiController
{
    public function verbs(): array
    {
        return [
            'index' => ['get'],
            'attach' => ['post'],
            'delete' => ['delete'],
            'update' => ['put', 'patch'],
        ];
    }

    /**
     * @OA\Get(path="/reports/index",
     *   summary="Поиск отчётов по промежутку дат",
     *   description="Осуществляет поиск отчётов пользователя по промежутку дат",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *      name="user_id",
     *      description="Идентификатор пользователя",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="fromDate",
     *      description="Дата начала поиска",
     *      in="query",
     *      @OA\Schema(
     *        type="DateTime",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="toDate",
     *      description="Дата конца периода поиска",
     *      in="query",
     *      @OA\Schema(
     *        type="DateTime",
     *      )
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
     */
    public function actionIndex(): array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        $reportsModel->attributes = $params;

        $reportsModel->limit = $params['limit'] ?? $reportsModel->limit;
        $reportsModel->offset = $params['offset'] ?? $reportsModel->offset;

        if (!$reportsModel->validate()) {
            return $reportsModel->errors;
        }

        return $reportsModel->byParams();
    }

    /**
     * @OA\Get(path="/reports/find-by-date",
     *   summary="Поиск отчётов по дате",
     *   description="Осуществляет поиск отчётов пользователя по дате",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *      name="user_id",
     *      description="Идентификатор пользователя",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="date",
     *      description="Дата поиска",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="DateTime",
     *      )
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
        if (!isset($params['user_id']) or !isset($params['date'])) {
            throw new NotFoundHttpException('Required parameter are missing!');
        }

        $reportsModel->attributes = $params;
        $reportsModel->date = $params['date'];

        if (!$this->checkDate($reportsModel->date)) {
            throw new BadRequestHttpException('Wrong date format');
        }

        if (!$reportsModel->validate()) {
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
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"tasks"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *          @OA\Property(
     *              property="created_at",
     *              type="Date",
     *              description="Дата создания отсета",
     *          ),
     *          @OA\Property(
     *              property="difficulties",
     *              type="string",
     *              description="Описание сложностей возникших при выполнении задач",
     *          ),
     *          @OA\Property(
     *              property="tomorrow",
     *              type="string",
     *              description="Описание планов на завтра",
     *          ),
     *          @OA\Property(
     *              property="Статус",
     *              type="integer",
     *              description="Статус",
     *          ),
     *          @OA\Property(
     *              property="project_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="company_id",
     *              type="integer",
     *              description="Идентификатор компании",
     *          ),
     *          @OA\Property(
     *              property="tasks[]",
     *              type="array",
     *              description="Массив выполненых задач",
     *                  @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="task",
     *                              description="Название задачи",
     *                              type="string",
     *                          ),
     *                          @OA\Property(
     *                              property="hours_spent",
     *                              description="Затраченное количество часов",
     *                              type="string",
     *                          ),
     *                          @OA\Property(
     *                              property="minutes_spent",
     *                              description="Затраченное количество минут",
     *                              type="string",
     *                          )
     *                      )
     *
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
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseCreateExample"),
     *     ),
     *   ),
     *)
     *
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionCreate(): array
    {
        $params = Yii::$app->request->post();
        if (!isset($params['tasks'])) {
            throw new BadRequestHttpException('Нет параметра tasks');
        }

        if (!isset($params['user_id'])) {
            $params['user_id'] = Yii::$app->user->id;
        }

        if (!isset($params['created_at'])) {
            $params['created_at'] = date("Y-m-d");
        }

        if (Reports::find()->where(['created_at' => $params['created_at'], 'user_id' => $params['user_id']])->exists()) {
            throw new BadRequestHttpException('Этот пользователь уже заполнил отчет в этот день');
        }

        $reportsModel = new Reports();
        $reportsModel->attributes = $params;
        if (!$reportsModel->validate() || !$reportsModel->save()) {
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $tasks = $params['tasks'];
        foreach ($tasks as $task) {
            $reportsTask = new ReportsTask();
            $reportsTask->load($task, '');
            $reportsTask->report_id = $reportsModel->id;
            $reportsTask->created_at = $reportsTask->created_at ?? strtotime($reportsModel->created_at);
            $reportsTask->status = $reportsTask->status ?? 1;

            if (!$reportsTask->validate() || !$reportsTask->save()) {
                throw new BadRequestHttpException(json_encode($reportsTask->errors));
            }
        }

        return array_merge($reportsModel->toArray());
    }


    /**
     * @OA\Delete (path="/reports/delete",
     *   summary="Удаление отчёта",
     *   description="Осуществляет удаление отчёта",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *      name="id",
     *      description="Идентификатор отчета",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
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
    public function actionDelete($id): bool
    {
        $report = Reports::findOne($id);

        if (null === $report) {
            throw new NotFoundHttpException('Report not found');
        }

        if (false === ($report->delete())) {
            throw new \RuntimeException('Report not deleted');
        }

        return true;
    }

    /**
     * @OA\Put (path="/reports/update",
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
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={},
     *          @OA\Property(
     *              property="created_at",
     *              type="DateTime",
     *              description="Дата создания (yyyy-mm-dd)",
     *          ),
     *          @OA\Property(
     *              property="today",
     *              type="string",
     *              description="Сделанное сегодня",
     *          ),
     *          @OA\Property(
     *              property="difficulties",
     *              type="string",
     *              description="Описание сложностей возникших при выполнении задач",
     *          ),
     *          @OA\Property(
     *              property="tomorrow",
     *              type="string",
     *              description="Описание планов на завтра",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус",
     *          ),
     *          @OA\Property(
     *              property="tasks[]",
     *              type="array",
     *              description="Массив выполненых задач",
     *                  @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="task",
     *                              description="Название задачи",
     *                              type="string",
     *                          ),
     *                          @OA\Property(
     *                              property="hours_spent",
     *                              description="Затраченное количество часов",
     *                              type="string",
     *                          ),
     *                          @OA\Property(
     *                              property="minutes_spent",
     *                              description="Затраченное количество минут",
     *                              type="string",
     *                          ),
     *                      ),
     *              ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Запроса",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseCreateExample"),
     *     ),
     *   ),
     *     ),
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): array
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $reportsModel = Reports::findone($id);

        if (!isset($reportsModel)) {
            throw new NotFoundHttpException('report not found');
        }

        if (!isset($params['tasks'])) {
            throw new BadRequestHttpException('Нет параметра tasks');
        }

        if (isset($params['user_id'])) {
            throw new \RuntimeException('constraint by user_card_id');
        }

        $reportsModel->load($params, '');

        if (!$reportsModel->validate()) {
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $reportsModel->save();

        ReportsTask::deleteAll(['report_id' => $reportsModel->id]);
        foreach ($params['tasks'] as $task) {
            $reportsTask = new ReportsTask();
            $reportsTask->load($task, '');
            $reportsTask->report_id = $reportsModel->id;
            $reportsTask->created_at = $reportsTask->created_at ?? strtotime($reportsModel->created_at);
            $reportsTask->status = $reportsTask->status ?? 1;

            if (!$reportsTask->validate()) {
                throw new BadRequestHttpException(json_encode($reportsTask->errors));
            }
            $reportsTask->save();
        }

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
        return ArrayHelper::toArray($reports, [
            'common\models\Reports' => [
                'date' => 'created_at',
                'id',
                'spendTime' => function (Reports $report) {
                    return $report->calculateOrderTime();
                },
            ],
        ]);
    }

    /**
     *
     * @OA\Post(path="/reports/add-task-to-report",
     *   summary="Добавить задачу в отчет",
     *   description="Метод для добавления задачи в существующий отчет",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"tasks", "report_id"},
     *          @OA\Property(
     *              property="report_id",
     *              type="integer",
     *              description="Идентификатор отчета",
     *          ),
     *          @OA\Property(
     *              property="tasks",
     *              type="string",
     *              description="Описание задачи",
     *          ),
     *          @OA\Property(
     *              property="hours_spent",
     *              type="string",
     *              description="Кол-во затраченых часов",
     *          ),
     *          @OA\Property(
     *              property="minutes_spent",
     *              type="string",
     *              description="Кол-во затраченых минут",
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
     *         @OA\Schema(ref="#/components/schemas/ReportsResponseCreateExample"),
     *     ),
     *   ),
     *)
     *
     * @return array
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionAddTaskToReport(): array
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $reportsModel = Reports::findone($params['report_id']);

        if (!isset($reportsModel)) {
            throw new NotFoundHttpException('report not found');
        }

        $reportTaskModel = new ReportsTask();
        $reportTaskModel->report_id = $params['report_id'];
        $reportTaskModel->task = $params['task'] ?? null;
        $reportTaskModel->hours_spent = $params['hours_spent'] ?? 0;
        $reportTaskModel->minutes_spent = $params['minutes_spent'] ?? 0;
        $reportTaskModel->created_at = time();
        $reportTaskModel->status = 1;

        if (!$reportTaskModel->validate()) {
            throw new BadRequestHttpException(json_encode($reportTaskModel->errors));
        }
        $reportTaskModel->save();

        return $reportsModel->toArray();
    }

    /**
     *
     * @OA\Get(path="/reports/find-or-create",
     *   summary="Поиск отчётов по дате, если отчета не существует, то он будет создан",
     *   description="Осуществляет поиск отчётов пользователя по дате, если отчета не существкет, то этот метод его создаст",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Reports"},
     *   @OA\Parameter(
     *      name="user_id",
     *      description="Идентификатор пользователя",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="created_at",
     *      description="Дата отчета",
     *      in="query",
     *      @OA\Schema(
     *        type="Date",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="project_id",
     *      description="Идентификатор проекта",
     *      in="query",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="company_id",
     *      description="Идентификатор компании",
     *      in="query",
     *      @OA\Schema(
     *        type="integer",
     *      )
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
     * @return array|Reports
     * @throws BadRequestHttpException
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionFindOrCreate(): array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        if (!isset($params['user_id']) or !isset($params['created_at'])) {
            throw new NotFoundHttpException('Required parameter are missing!');
        }

        $reportsModel->attributes = $params;
        $reportsModel->date = $params['created_at'];

        if (!$reportsModel->validate()) {
            return $reportsModel->errors;
        }

        $model =  $reportsModel->findByDate();

        if (!$model){
            $model = new Reports();
            $model->load($params, '');
            if (!$model->validate() || !$model->save()) {
                throw new BadRequestHttpException(json_encode($reportsModel->errors));
            }
        }

        return $model;
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
