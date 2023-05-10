<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="ProjectColumn",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=95,
 *     description="Идентификатор колонки"
 *  ),
 *  @OA\Property(
 *     property="title",
 *     type="string",
 *     example="Задачи на проверку",
 *     description="Название колонки"
 *  ),
 *  @OA\Property(
 *     property="project_id",
 *     type="int",
 *     example="95",
 *     description="Проект к которому относится колонка"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="1",
 *     description="Статус колонки"
 *  ),
 *  @OA\Property(
 *     property="priority",
 *     type="int",
 *     example="1",
 *     description="Приоритет колонки"
 *  ),
 *  @OA\Property(
 *     property="tasks",
 *     ref="#/components/schemas/ProjectTask",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectColumnExample",
 *  type="array",
 *  example={
 *     {"id": 1, "title": "Задачи на проверку", "project_id": 95, "status": 1, "priority": 1,
 *         "tasks": {
 *             {"id": 95, "title": "Сложная задача", "project_id": 44, "column_id": 1, "user_id": 19, "description": "Описание задачи", "status": 1,
 *                 "taskUsers": {
 *                     {"id": 2, "task_id": 95, "user_id": 2, "fio": "Сапронов Антон Викторович", "avatar": "/profileava/m8.png"},
 *                     {"id": 3, "task_id": 95, "user_id": 3, "fio": "Иванов Иван Иванович", "avatar": "/profileava/m2.png"},
 *                 }
 *             },
 *             {"id": 96, "title": "Простая задача", "project_id": 44, "column_id": 1, "user_id": 19, "description": "Описание простой задачи", "status": 1,
 *                 "taskUsers": {
 *                     {"id": 3, "task_id": 96, "user_id": 3, "fio": "Иванов Иван Иванович", "avatar": "/profileava/m2.png"},
 *                     {"id": 4, "task_id": 96, "user_id": 4, "fio": "Петров Петр Петрович", "avatar": "/profileava/m7.png"},
 *                 }
 *             }
 *         }
 *     },
 *     {"id": 2, "title": "Новые задачи", "project_id": 95, "status": 1, "priority": 2,
 *         "tasks": {
 *             {"id": 97, "title": "Очень Сложная задача", "project_id": 44, "column_id": 2, "user_id": 19, "description": "Описание простой задачи", "status": 1},
 *             {"id": 98, "title": "Очень Простая задача", "project_id": 44, "column_id": 2, "user_id": 19, "description": "Описание очень простой задачи", "status": 1}
 *         }
 *     }
 *  },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="title",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="project_id",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="priority",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="tasks",
 *         ref="#/components/schemas/ProjectTask",
 *      ),
 *  ),
 *)
 *
 */
class ProjectColumn extends \common\models\ProjectColumn
{

}