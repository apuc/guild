<?php

namespace frontend\modules\api\services;

use common\models\forms\TasksImportForm;
use common\services\ImportProjectTaskService;
use frontend\modules\api\models\project\ProjectTask;
use frontend\modules\api\models\project\ProjectTaskUser;
use yii\web\BadRequestHttpException;

class TaskService
{
    public ImportProjectTaskService $importProjectTaskService;

    public function __construct(ImportProjectTaskService $importProjectTaskService)
    {
        $this->importProjectTaskService = $importProjectTaskService;
    }

    public function createTask($taskParams)
    {
        $task = new ProjectTask();
        $task->load($taskParams, '');
        $task->save();
        return $task;
    }

    public function getTask($task_id): ?ProjectTask
    {
        return ProjectTask::findOne($task_id);
    }

    public function getTaskList($status = null): array
    {
        return ProjectTask::find()->asArray()->all();
    }

    public function getTaskListByProject($project_id, $user_id): array
    {
        $query = ProjectTask::find()->where(['project_id' => $project_id]);

        if ($user_id) {
            $query->andWhere(['user_id' => $user_id]);
        }
        return $query->orderBy('priority DESC')->all();
    }

    public function getArchiveTask($project_id, $user_id): array
    {
        $query = ProjectTask::find()->where(['project_id' => $project_id])->andWhere(['status' => ProjectTask::STATUS_ARCHIVE]);

        if ($user_id) {
            $query->andWhere(['user_id' => $user_id]);
        }
        return $query->orderBy('priority DESC')->all();
    }

    public function getTaskListByUser($user_id): array
    {
        $taskIdList = ProjectTaskUser::find()->where(['user_id' => $user_id])->select('task_id')->column();
        return ProjectTask::find()->where([ 'IN', 'id', $taskIdList])->orWhere(['user_id' => $user_id])->orderBy('priority DESC')->all();
    }

    public function updateTask($task_params): ?ProjectTask
    {
        $modelTask = ProjectTask::findOne($task_params['task_id']);

        if (isset($task_params['executor_id']) && $task_params['executor_id'] == 0){
            $task_params['executor_id'] = null;
        }

        $modelTask->load($task_params, '');
        $modelTask->save();

        return $modelTask;
    }

    public function taskExists($task_id): bool
    {
        return ProjectTask::find()->where(['id' => $task_id])->exists();
    }

    /**
     * @throws BadRequestHttpException
     */
    public function importTasks(array $params)
    {
        $form = new TasksImportForm();
        $form->load($params);

        if (!$form->validate()){
            $errors = $form->errors;
            throw new BadRequestHttpException(array_shift($errors)[0]);
        }

        $query = ProjectTask::genQueryToImport(
            $form->companyId,
            $form->userId,
            $form->projectId,
            $form->fromDate,
            $form->toDate
        );

        $tasks = $query->all();

        if (!$tasks) {
            return null;
        }

        return $this->importProjectTaskService->importTasks($tasks);
    }
}