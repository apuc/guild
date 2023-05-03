<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="ManagerEmployee",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=95,
 *     description="Идентификатор задачи"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example="19",
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="managerEmployees",
 *     ref="#/components/schemas/ManagerEmployees",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ManagerEmployees",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         example="1"
 *      ),
 *      @OA\Property(
 *         property="manager_id",
 *         type="integer",
 *         example="1"
 *      ),
 *      @OA\Property(
 *         property="employee_id",
 *         type="integer",
 *         example="19"
 *      ),
 *      @OA\Property(
 *          property="employee",
 *          type="object",
 *          ref="#/components/schemas/ProjectTaskUsersShortExample",
 *      ),
 *  ),
 *)
 *
 */
class ManagerEmployee extends \common\models\ManagerEmployee
{

}