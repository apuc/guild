<?php

namespace frontend\modules\api\services;

use common\models\Entity;
use common\models\forms\TasksImportForm;
use common\services\ImportProjectTaskService;
use DateTime;
use frontend\modules\api\models\project\ProjectTask;
use frontend\modules\api\models\project\ProjectTaskUser;
use frontend\modules\api\models\Timer;
use yii\web\BadRequestHttpException;

class TaskService
{
    public ImportProjectTaskService $importProjectTaskService;

    public function __construct(ImportProjectTaskService $importProjectTaskService)
    {
        $this->importProjectTaskService = $importProjectTaskService;
    }

    public static function getOpenTaskCount(int $user_id, int $project_id): bool|int|string|null
    {
        return ProjectTask::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['project_id' => $project_id])
            ->andWhere(['in', 'status', ProjectTask::openTaskStatusList()])
            ->count();
    }

    public static function getHoursWorkedForCurrentMonth(int $user_id, int $project_id)
    {
        $projectTaskIdArr = ProjectTask::find()
            ->select('id')
            ->where(['user_id' => $user_id])
            ->andWhere(['project_id' => $project_id])
            ->column();

        $firstMonthDay = new DateTime('first day of this month');
        $firstMonthDay->setTime(00, 00, 01);
        $firstMonthDay = $firstMonthDay->format('Y-m-d H:i:s');


        $lastMonthDay = new DateTime('last day of this month');
        $lastMonthDay->setTime(23, 59, 00);
        $lastMonthDay = $lastMonthDay->format('Y-m-d H:i:s');

        $timers = Timer::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['entity_type' => Entity::ENTITY_TYPE_TASK])
            ->andWhere(['in', 'entity_id', $projectTaskIdArr])
            ->andWhere(['between', 'created_at', $firstMonthDay, $lastMonthDay ])
            ->all();

        $hours = 0;
        /** @var Timer $timer */
        foreach ($timers as $timer) {
            // Create two new DateTime-objects...
            $date1 = new DateTime($timer->created_at);
            $date2 = new DateTime($timer->stopped_at);

            $diff = $date2->diff($date1);

            $hours += $diff->h + ($diff->days*24);

        }
        return $hours;
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