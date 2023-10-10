<?php

namespace frontend\modules\api\controllers;

use common\classes\Debug;
use common\models\ProjectTask;
use common\models\ProjectTaskUser;
use common\models\User;
use common\services\TaskService;
use frontend\modules\api\models\ProjectColumn;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class TaskController extends ApiController
{
    public function verbs(): array
    {
        return [
            'get-task' => ['get'],
            'get-task-list' => ['get'],
            'get-user-tasks' => ['get'],
            'create-task' => ['post'],
            'update-task' => ['put', 'patch'],
            'add-user-to-task' => ['post'],
            'del-user' => ['delete'],
        ];
    }

    /**
     *
     * @OA\Post(path="/task/create-task",
     *   summary="Добавить задачу",
     *   description="Метод для создания задачи, если не передан параметр <b>user_id</b>, то будет получен текущий пользователь",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"project_id", "status", "title", "description"},
     *          @OA\Property(
     *              property="project_id",
     *              type="string",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Заголовок задачи",
     *          ),
     *          @OA\Property(
     *              property="description",
     *              type="string",
     *              description="Описание задачи",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="статус",
     *          ),
     *          @OA\Property(
     *              property="dead_line",
     *              type="string",
     *              description="Срок выполнения задачи",
     *          ),
     *          @OA\Property(
     *              property="priority",
     *              type="integer",
     *              description="Приоритет задачи",
     *          ),
     *          @OA\Property(
     *              property="column_id",
     *              type="integer",
     *              description="Колонка к которой относится задача",
     *          ),
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор создателя задачи",
     *          ),
     *          @OA\Property(
     *              property="executor_id",
     *              type="integer",
     *              description="Идентификатор исполнителя задачи",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект задачи",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTask"),
     *     ),
     *   ),
     * )
     *
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionCreateTask(): ProjectTask
    {
        $request = Yii::$app->getRequest()->getBodyParams();
        if (!isset($request['user_id']) or $request['user_id'] == null) {
            $request['user_id'] = Yii::$app->user->id;
        }

        $taskModel = TaskService::createTask($request);
        if ($taskModel->errors) {
            throw new ServerErrorHttpException(json_encode($taskModel->errors));
        }
        return $taskModel;
    }


    /**
     *
     * @OA\Get(path="/task/get-task-list",
     *   summary="Получить список задач по проекту",
     *   description="Метод для получения задач по проекту",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="project_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="expand",
     *      in="query",
     *      example="column,timers",
     *      description="В этом параметре по необходимости передаются поля, которые нужно добавить в ответ сервера, сейчас доступно только поля <b>column</b>, <b>timers</b>",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов Задач",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTaskExample"),
     *     ),
     *   ),
     * )
     *
     * @throws NotFoundHttpException
     */
    public function actionGetTaskList($project_id): array
    {
        $tasks = array();
        if ($project_id) {
            if (empty($project_id) or !is_numeric($project_id)) {
                throw new NotFoundHttpException('Incorrect project ID');
            }
            $tasks = TaskService::getTaskListByProject($project_id);
        } else {
            $tasks = TaskService::getTaskList($project_id);
        }

        if (empty($tasks)) {
            throw new NotFoundHttpException('The project does not exist or there are no tasks for it');
        }
        return $tasks;
    }

    /**
     *
     * @OA\Get(path="/task/get-user-tasks",
     *   summary="Получить список задач по пользователю",
     *   description="Метод для получения задач по пользователю",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="expand",
     *      in="query",
     *      example="column,timers",
     *      description="В этом параметре по необходимости передаются поля, которые нужно добавить в ответ сервера, сейчас доступно только поля <b>column</b>, <b>timers</b>",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив объектов Задач",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTaskExample"),
     *     ),
     *   ),
     * )
     *
     * @param $user_id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetUserTasks($user_id): array
    {
        $tasks = array();
        if ($user_id) {
            if (empty($user_id) or !is_numeric($user_id)) {
                throw new NotFoundHttpException('Incorrect project ID');
            }
            $tasks = TaskService::getTaskListByUser($user_id);
        } else {
            $tasks = TaskService::getTaskList($user_id);
        }

        if (empty($tasks)) {
            throw new NotFoundHttpException('The project does not exist or there are no tasks for it');
        }
        return $tasks;
    }

    /**
     *
     * @OA\Get(path="/task/get-task",
     *   summary="Получить информацию по задаче",
     *   description="Метод для получения данных по задаче",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *   @OA\Parameter(
     *      name="task_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="expand",
     *      in="query",
     *      example="column,timers",
     *      description="В этом параметре по необходимости передаются поля, которые нужно добавить в ответ сервера, сейчас доступно только поля <b>column</b>, <b>timers</b>",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Задачи",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTask"),
     *     ),
     *   ),
     * )
     *
     * @throws NotFoundHttpException
     */
    public function actionGetTask($task_id): ProjectTask
    {
        if (empty($task_id) or !is_numeric($task_id)) {
            throw new NotFoundHttpException('Incorrect task ID');
        }

        $task = TaskService::getTask($task_id);
        if (empty($task)) {
            throw new NotFoundHttpException('The task does not exist');
        }

        return $task;
    }

    /**
     *
     * @OA\Put(path="/task/update-task",
     *   summary="Редактировать задачу",
     *   description="Метод для редактирования задачи",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"task_id"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *              nullable=false,
     *          ),
     *          @OA\Property(
     *              property="executor_id",
     *              type="integer",
     *              description="Идентификатор исполнителя задачи",
     *          ),
     *          @OA\Property(
     *              property="task_id",
     *              type="integer",
     *              description="Идентификатор задачи",
     *          ),
     *          @OA\Property(
     *              property="title",
     *              type="string",
     *              description="Заголовок задачи",
     *          ),
     *          @OA\Property(
     *              property="column_id",
     *              type="integer",
     *              description="Идентификатор колонки",
     *          ),
     *          @OA\Property(
     *              property="priority",
     *              type="integer",
     *              description="Приоритет задачи",
     *          ),
     *          @OA\Property(
     *              property="status",
     *              type="integer",
     *              description="Статус задачи",
     *          ),
     *          @OA\Property(
     *              property="dead_line",
     *              type="string",
     *              description="Срок выполнения задачи",
     *          ),
     *          @OA\Property(
     *              property="description",
     *              type="string",
     *              description="Описание запроса",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект Задачи",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTask"),
     *     ),
     *   ),
     * )
     *
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateTask(): ?ProjectTask
    {
        $params = array_diff(\Yii::$app->request->getBodyParams(), [null, '']);
        if (empty ($params['task_id']) or !TaskService::taskExists($params['task_id'])) {
            throw new NotFoundHttpException('The task does not exist');
        }

        $modelTask = TaskService::updateTask($params);
        if (!empty($modelTask->hasErrors())) {
            throw new ServerErrorHttpException(json_encode($modelTask->errors));
        }

        return $modelTask;
    }

    /**
     *
     * @OA\Post(path="/task/add-user-to-task",
     *   summary="Добавить пользователя в задачу",
     *   description="Метод для добавления пользователя в задачу",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"user_id", "task_id"},
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *          @OA\Property(
     *              property="task_id",
     *              type="integer",
     *              description="Идентификатор задачи",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект связи задачи и пользователя",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTaskUser"),
     *     ),
     *   ),
     * )
     *
     * @return ProjectTaskUser
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionAddUserToTask(): ProjectTaskUser
    {
        $request = \Yii::$app->request->post();

        $user = User::findOne($request['user_id']);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        if (empty ($request['task_id']) or !TaskService::taskExists($request['task_id'])) {
            throw new NotFoundHttpException('The task does not exist');
        }

        if (ProjectTaskUser::find()->where(['user_id' => $request['user_id'], 'task_id' => $request['task_id']])->exists()) {
            throw new ServerErrorHttpException('The user has already been added');
        }

        $model = new ProjectTaskUser();
        $model->load($request, '');

        if (!$model->validate()) {
            throw new ServerErrorHttpException($model->errors);
        }

        $model->save();

        return $model;
    }

    /**
     *
     * @OA\Delete(path="/task/del-user",
     *   summary="Удаление пользователя из задачи",
     *   description="Метод для Удаления пользователя из задачи",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *          required={"task_id", "user_id"},
     *          @OA\Property(
     *              property="task_id",
     *              type="integer",
     *              description="Идентификатор задачи",
     *          ),
     *          @OA\Property(
     *              property="user_id",
     *              type="integer",
     *              description="Идентификатор пользователя",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект задачи",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectTask"),
     *     ),
     *   ),
     * )
     *
     * @return ProjectTask|null
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionDelUser(): ?ProjectTask
    {
        $request = Yii::$app->request->getBodyParams();

        $user = User::findOne($request['user_id']);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        if (empty ($request['task_id']) or !TaskService::taskExists($request['task_id'])) {
            throw new NotFoundHttpException('The task does not exist');
        }

        ProjectTaskUser::deleteAll(['task_id' => $request['task_id'], 'user_id' => $request['user_id']]);

        return TaskService::getTask($request['task_id']);
    }

    /**
     *
     * @OA\Post(path="/task/set-priority",
     *   summary="Установить приоритет задач",
     *   description="Метод для установления приоритета задач в колонке",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"TaskManager"},
     *
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *          required={"column_id", "data"},
     *          @OA\Property(
     *              property="column_id",
     *              type="integer",
     *              description="Идентификатор проекта",
     *          ),
     *          @OA\Property(
     *              property="data",
     *              type="string",
     *              description="Данные для обновления приоритета. Пример: [{&quot;task_id&quot;:3,&quot;priority&quot;:2},{&quot;task_id&quot;:4,&quot;priority&quot;:3}]",
     *          ),
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает объект колонки",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/ProjectColumn"),
     *     ),
     *   ),
     * )
     *
     * @return ProjectColumn
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSetPriority(): ProjectColumn
    {
        $request = \Yii::$app->request->post();
        $data = $request['data'];

        if (!$data = json_decode($data, true)) {
            throw new BadRequestHttpException('No valid JSON');
        }

        $column = ProjectColumn::findOne($request['column_id']);
        if (empty($column)) {
            throw new NotFoundHttpException('The column not found');
        }

        foreach ($data as $datum) {
            $model = ProjectTask::findOne($datum['task_id']);
            $model->priority = $datum['priority'];
            if (!$model->validate()){
                throw new BadRequestHttpException($model->errors);
            }
            $model->save();
        }

        return $column;
    }
}