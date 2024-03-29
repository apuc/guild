<?php

namespace frontend\modules\api\controllers;

use common\models\ProjectTaskUser;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TaskUserController extends ApiController
{
    public function verbs(): array
    {
        return [
            'get-task-users' => ['get'],
            'set-task-user' => ['post', 'patch'],
        ];
    }

    public function actionSetTaskUser()
    {
        $taskUserModel = new ProjectTaskUser();

        $params = Yii::$app->request->post();
        $taskUserModel->attributes = $params;

        if(!$taskUserModel->validate()){
            throw new BadRequestHttpException(json_encode($taskUserModel->errors));
        }

        $taskUserModel->save();

        return $taskUserModel->toArray();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTaskUsers()
    {
        $task_id = Yii::$app->request->get('task_id');
        if(empty($task_id) or !is_numeric($task_id))
        {
            throw new NotFoundHttpException('Incorrect task ID');
        }

        $tasks = $this->findUsers($task_id);

        if(empty($tasks)) {
            throw new NotFoundHttpException('The task does not exist or there are no employees for it');
        }

        return $tasks;
    }

    private function findUsers($project_id): array
    {
        return ProjectTaskUser::find()->where(['task_id' => $project_id])->all();
    }
}