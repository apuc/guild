<?php

namespace frontend\modules\api\controllers;

use common\models\Task;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class TaskController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

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
     * @throws NotFoundHttpException
     */
    public function actionUpdate(): ?Task
    {
        $model = $this->findModelTask(Yii::$app->request->post('task_id'));
        if(empty($model)) {
            throw new NotFoundHttpException('The task does not exist');
        }

        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }



    /**
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCreateTask(): Task
    {
        $task = Yii::$app->getRequest()->getBodyParams();

        $model = new Task();
        $model->load($task, '');

        $this->validateTaskModel($model);
        $this->saveModel($model);

        return $model;
    }

    /**
     * @throws ServerErrorHttpException
     */
    protected function saveModel($model)
    {
        if ($model->save()) {
            $task = Yii::$app->getResponse();
            $task->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    /**
     * @throws BadRequestHttpException
     */
    protected function validateTaskModel($model)
    {
        if(!$model->validate()) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if (empty($model->project_id)or empty($model->status)
            or empty($model->description) or empty($model->title) or empty($model->project_user_id)) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }

    public function actionGetTaskList(): array
    {
        $project_id = Yii::$app->request->get('project_id');
        if(empty($project_id) or !is_numeric($project_id))
        {
            throw new NotFoundHttpException('Incorrect project ID');
        }

        $tasks = $this->findModelsById($project_id);

        if(empty($tasks)) {
            throw new NotFoundHttpException('The project does not exist or there are no tasks for it');
        }

        return $tasks;
    }

    public function actionGetTask(): Task
    {
        $task_id = Yii::$app->request->get('task_id');
        if(empty($task_id) or !is_numeric($task_id))
        {
            throw new NotFoundHttpException('Incorrect task ID');
        }

        $task = $this->findModelTask($task_id);

        if(empty($task)) {
            throw new NotFoundHttpException('The task does not exist');
        }

        return $task;

    }

    private function findModelTask($task_id): ?Task
    {
        return Task::findOne($task_id);
    }

    private function findModelsById($project_id): array
    {
        return Task::find()->where(['project_id' => $project_id])->all();
    }
}