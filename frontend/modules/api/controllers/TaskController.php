<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectTask;
use common\services\TaskService;
use Yii;
use yii\base\InvalidConfigException;
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
        ];
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionCreateTask(): ProjectTask
    {
        $taskModel = TaskService::createTask(Yii::$app->getRequest()->getBodyParams());
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
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): ?ProjectTask
    {
        $params = Yii::$app->request->getBodyParams();
        if (empty ($params['task_id']) or !TaskService::taskExists($params['task_id'])) {
            throw new NotFoundHttpException('The task does not exist');
        }

        $modelTask = TaskService::updateTask($params);
        if (!empty($modelTask->hasErrors())) {
            throw new ServerErrorHttpException(json_encode('Bad params'));
        }

        return $modelTask;
    }
}