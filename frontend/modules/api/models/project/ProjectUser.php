<?php

namespace frontend\modules\api\models\project;

/**
 *
 * @OA\Schema(
 *  schema="ProjectUsers",
 *  @OA\Property(
 *     property="project_id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор проекта"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="user",
 *     ref="#/components/schemas/ProjectTaskUsersShortExample",
 *     description="Пользователи проекта"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectUsersExample",
 *  type="array",
 *  example={
 *     {"project_id": 20, "user_id": 19, "user": {"fio": "Иванов Иван Иванович", "avatar": "/profileava/m6.png"}},
 *     {"project_id": 20, "user_id": 20, "user": {"fio": "Петров Петр Петрович", "avatar": "/profileava/m2.png"}},
 *     },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="project_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/ProjectTaskUsersShortExample",
 *      ),
 *  ),
 *)
 *
 */
class ProjectUser extends \common\models\ProjectUser
{

    public function fields()
    {
        return [
            'project_id',
            'user_id',
            'user' => function(){
                return [
                    'fio' => $this->user->userCard->fio ?? $this->user->email,
                    'avatar' => $this->user->userCard->photo ?? ''
                ];
            }
        ];
    }

}