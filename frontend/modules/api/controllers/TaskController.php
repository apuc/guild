<?php

namespace frontend\modules\api\controllers;

use common\models\Task;
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
            'create-task' => ['post'],
            'update-task' => ['put', 'patch'],
        ];
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionCreateTask(): Task
    {
        $taskModel = TaskService::createTask(Yii::$app->getRequest()->getBodyParams());
        if ($taskModel->errors) {
            throw new ServerErrorHttpException(json_encode($taskModel->errors));
        }

        return $taskModel;
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTaskList($project_id  = null): array
    {
        $tasks = array();
        if ($project_id)
        {
            if(empty($project_id) or !is_numeric($project_id))
            {
                throw new NotFoundHttpException('Incorrect project ID');
            }
            $tasks = TaskService::getTaskListByProject($project_id);
        }
        else
        {
            $tasks = TaskService::getTaskList($project_id);
        }

        if(empty($tasks)) {
            throw new NotFoundHttpException('The project does not exist or there are no tasks for it');
        }
        return $tasks;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTask($task_id): Task
    {
        if(empty($task_id) or !is_numeric($task_id))
        {
            throw new NotFoundHttpException('Incorrect task ID');
        }

        $task = TaskService::getTask($task_id);
        if(empty($task)) {
            throw new NotFoundHttpException('The task does not exist');
        }

        return $task;
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): ?Task
    {
        $params = Yii::$app->request->getBodyParams();
        if (empty ($params['task_id']) or !TaskService::taskExists($params['task_id']))
        {
            throw new NotFoundHttpException('The task does not exist');
        }

        $modelTask = TaskService::updateTask($params);
        if (!empty($modelTask->hasErrors())) {
            throw new ServerErrorHttpException(json_encode('Bad params'));
        }

        return $modelTask;
    }
}