<?php

namespace common\services;

use common\models\Task;

class TaskService
{
    public static function createTask($taskParams)
    {
        $task = new Task();
        $task->load($taskParams, '');
        $task->save();
        return $task;
    }

    public static function getTask($task_id): ?Task
    {
        return Task::findOne($task_id);
    }

    public static function getTaskList($task_id): array
    {
        return Task::find()->asArray()->all();
    }

    public static function getTaskListByProject($project_id): array
    {
        return Task::find()->where(['project_id' => $project_id])->asArray()->all();
    }

    public static function updateTask($task_params): ?Task
    {
        $modelTask = Task::findOne($task_params['task_id']);

        $modelTask->load($task_params, '');
        $modelTask->save();

        return $modelTask;
    }

    public static function taskExists($task_id): bool
    {
        return Task::find()->where(['id' => $task_id])->exists();
    }
}