<?php

namespace common\services;

use common\models\ProjectTask;

class TaskService
{
    public static function createTask($taskParams)
    {
        $task = new ProjectTask();
        $task->load($taskParams, '');
        $task->save();
        return $task;
    }

    public static function getTask($task_id): ?ProjectTask
    {
        return ProjectTask::findOne($task_id);
    }

    public static function getTaskList($task_id): array
    {
        return ProjectTask::find()->asArray()->all();
    }

    public static function getTaskListByProject($project_id): array
    {
        return ProjectTask::find()->where(['project_id' => $project_id])->asArray()->all();
    }

    public static function getTaskListByUser($user_id): array
    {
        return ProjectTask::find()->where(['user_id' => $user_id])->all();
    }

    public static function updateTask($task_params): ?ProjectTask
    {
        $modelTask = ProjectTask::findOne($task_params['task_id']);

        $modelTask->load($task_params, '');
        $modelTask->save();

        return $modelTask;
    }

    public static function taskExists($task_id): bool
    {
        return ProjectTask::find()->where(['id' => $task_id])->exists();
    }
}