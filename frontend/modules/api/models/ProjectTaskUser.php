<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="ProjectTaskUser",
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example=19,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="task_user",
 *     type="int",
 *     example=23,
 *     description="Идентификатор задачи"
 *  ),
 *)
 *
 */
class ProjectTaskUser extends \common\models\ProjectTaskUser
{

}