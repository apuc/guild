<?php

namespace frontend\modules\api\models\project;

/**
 *
 * @OA\Schema(
 *  schema="ProjectParticipants",
 *  @OA\Property(
 *     property="avatar",
 *     type="string",
 *     example="/hbfhdb/b4.png",
 *     description="Ссылка на аватар профиля"
 *  ),
 *  @OA\Property(
 *     property="username",
 *     type="string",
 *     example="username",
 *     description="ФИО пользователя"
 *  ),
 *  @OA\Property(
 *     property="email",
 *     type="string",
 *     example="test@email.com",
 *     description="Email пользователя"
 *  ),
 *  @OA\Property(
 *     property="role",
 *     type="string",
 *     example="Разработчик",
 *     description="Роль пользователя на проекте"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="0",
 *     description="Статус (0 - не активен, 1 - активен)"
 *  ),
 *)
 *
 * @OA\Schema(
 *      schema="ProjectParticipantsExample",
 *      type="array",
 *      example={"avatar": "/hbfhdb/b4.png", "username": "username", "email": "test@email.com", "role": "Разработчик", "status": 0},
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="avatar",
 *         type="string",
 *         example="/hbfhdb/b4.png",
 *      ),
 *      @OA\Property(
 *         property="username",
 *         type="string",
 *         example="username",
 *      ),
 *      @OA\Property(
 *         property="email",
 *         type="string",
 *         example="test@email.com",
 *      ),
 *      @OA\Property(
 *         property="role",
 *         type="string",
 *         example="Разработчик",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="int",
 *         example="0",
 *      ),
 *  ),
 *  )
 *
 *
 *
 *
 * @OA\Schema(
 *  schema="ProjectParticipantsExampleArr",
 *  type="array",
 *  example={
 *     {"avatar": "/hbfhdb/b4.png", "username": "username", "email": "test@email.com", "role": "Разработчик", "status": 0},
 *     {"avatar": "/hbfhdb/b4.png", "username": "username", "email": "test@email.com", "role": "Разработчик", "status": 1},
 *  },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="avatar",
 *         type="string",
 *         example="/hbfhdb/b4.png",
 *      ),
 *      @OA\Property(
 *         property="username",
 *         type="string",
 *         example="username",
 *      ),
 *      @OA\Property(
 *         property="email",
 *         type="string",
 *         example="test@email.com",
 *      ),
 *      @OA\Property(
 *         property="role",
 *         type="string",
 *         example="Разработчик",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="int",
 *         example="0",
 *      ),
 *  ),
 *)
 *
 */
class ProjectParticipants extends ProjectUser
{

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'avatar' => function () {
                return $this->user->userCard->photo ?? '';
            },
            'username' => function () {
                return $this->card->fio ?? null;
            },
            'email' => function () {
                return $this->card->email ?? $this->user->email;
            },
            'role' => function () {
                return $this->projectRole->title ?? null;
            },
            'status' => function () {
                return $this->status ?? null;
            },
        ];
    }
}