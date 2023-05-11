<?php

namespace frontend\modules\api\models;

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
 *     property="status",
 *     type="int",
 *     example="1",
 *     description="Статус задачи"
 *  ),
 *  @OA\Property(
 *     property="taskUsers",
 *     ref="#/components/schemas/ProjectTaskUsersExample",
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
 */
class ProjectTask extends \common\models\ProjectTask
{

}