<?php

namespace frontend\modules\api\models\project;

/**
 *
 * @OA\Schema(
 *  schema="ProjectTask",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=95,
 *     description="Идентификатор задачи"
 *  ),
 *  @OA\Property(
 *     property="title",
 *     type="string",
 *     example="Задачи на проверку",
 *     description="Заголовок задачи"
 *  ),
 *  @OA\Property(
 *     property="project_id",
 *     type="int",
 *     example="95",
 *     description="Проект к которому относится задача"
 *  ),
 *  @OA\Property(
 *     property="column_id",
 *     type="int",
 *     example="23",
 *     description="Колонка к которой относится задача"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example="19",
 *     description="Идентификатор пользователя создавшего задачу"
 *  ),
 *  @OA\Property(
 *     property="user",
 *     ref="#/components/schemas/ProjectTaskUsersShortExample",
 *     description="Пользователь создавший задачу"
 *  ),
 *  @OA\Property(
 *     property="dead_line",
 *     type="string",
 *     example="2023-04-21 00:44:53",
 *     description="Срок выполнения задачи"
 *  ),
 *  @OA\Property(
 *     property="executor_id",
 *     type="int",
 *     example="2",
 *     description="Идентификатор исполнителя задачи"
 *  ),
 *  @OA\Property(
 *     property="executor",
 *     ref="#/components/schemas/ProjectTaskUsersShortExample",
 *     description="Исполнитель задачи"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     example="Описание задачи",
 *     description="Описание задачи"
 *  ),
 *  @OA\Property(
 *     property="priority",
 *     type="int",
 *     example="1",
 *     description="Приоритет задачи"
 *  ),
 *  @OA\Property(
 *     property="execution_priority",
 *     type="integer",
 *     example="2",
 *     description="Приоритет выполнения задачи (0 - low, 1 - medium, 2 - high)",
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="1",
 *     description="Статус задачи(0 - disable, 1 - active, 2 - archive)"
 *  ),
 *  @OA\Property(
 *     property="comment_count",
 *     type="int",
 *     example="5",
 *     description="Кол-во комментариев"
 *  ),
 *  @OA\Property(
 *     property="taskUsers",
 *     ref="#/components/schemas/ProjectTaskUsersExample",
 *  ),
 *  @OA\Property(
 *     property="timers",
 *     ref="#/components/schemas/TimerExample",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectTaskExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      ref="#/components/schemas/ProjectTask",
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="ProjectTaskUsersExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         example="1"
 *      ),
 *      @OA\Property(
 *         property="task_id",
 *         type="integer",
 *         example="1"
 *      ),
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example="19"
 *      ),
 *      @OA\Property(
 *         property="fio",
 *         type="string",
 *         example="Сапронов Антон Викторович"
 *      ),
 *      @OA\Property(
 *         property="avatar",
 *         type="string",
 *         example="/profileava/m8.png"
 *      ),
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectTaskUsersShortExample",
 *      @OA\Property(
 *         property="fio",
 *         type="string",
 *         example="Сапронов Антон Викторович"
 *      ),
 *      @OA\Property(
 *         property="avatar",
 *         type="string",
 *         example="/profileava/m8.png"
 *      ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectTaskReportsExample",
 *             type="array",
 *             @OA\Items(
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *      ),
 *      @OA\Property(
 *         property="report_id",
 *         type="integer",
 *         example=12
 *      ),
 *      @OA\Property(
 *         property="task",
 *         type="string",
 *         example="Задача"
 *      ),
 *      @OA\Property(
 *         property="hours_spent",
 *         type="integer",
 *         example=2
 *      ),
 *      @OA\Property(
 *         property="created_at",
 *         type="integer",
 *         example=1671148800
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="integer",
 *         example=1
 *      ),
 *      @OA\Property(
 *         property="minutes_spent",
 *         type="integer",
 *         example=0
 *      ),
 *             )
 *
 *

 *)
 *
 */
class ProjectTask extends \common\models\ProjectTask
{

}