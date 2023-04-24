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
 *     description="Пользователь создавший задачу"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     example="Описание задачи",
 *     description="Описание задачи"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="1",
 *     description="Статус колонки"
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
 */
class ProjectTask extends \common\models\ProjectTask
{

}