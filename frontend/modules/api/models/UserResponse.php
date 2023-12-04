<?php

namespace frontend\modules\api\models;


/**
 *
 * @OA\Schema(
 *  schema="UserResponse",
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="question_id",
 *     type="int",
 *     example="7",
 *     description="Идентификатор вопроса"
 *  ),
 *  @OA\Property(
 *     property="response_body",
 *     type="string",
 *     example="Ответ",
 *     description="Ответ пользователя"
 *  ),
 *  @OA\Property(
 *     property="user_questionnaire_uuid",
 *     type="string",
 *     example="d222f858-60fd-47fb-8731-dc9d5fc384c5",
 *     description="UUID анкеты назначенной пользователю"
 *  ),
 *  @OA\Property(
 *     property="created_at",
 *     type="string",
 *     example="2021-10-20 13:06:12",
 *     description="Дата создания"
 *  ),
 *  @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     example="2022-11-20 10:35:12",
 *     description="Дата обновления"
 *  ),
 *  @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="5",
 *     description="ID ответа"
 *  ),
 *  @OA\Property(
 *     property="answer_flag",
 *     type="bool",
 *     example="0",
 *     description="Флаг ответа"
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *      schema="UserResponseExample",
 *      type="array",
 *      @OA\Items(
 *          type="object",
 *          ref="#/components/schemas/UserResponse",
 *      ),
 *  )
 *
 * @OA\Schema(
 *  schema="UserResponseExampleArr",
 *  type="array",
 *  example={
 *     {"user_id": 23, "question_id": 22, "response_body": "Ответ 1", "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",},
 *     {"user_id": 16, "question_id": 3, "response_body": "Ответ 22", "user_questionnaire_uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5",},
 *  },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="question_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="response_body",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="user_questionnaire_uuid",
 *         type="string",
 *      ),
 *  ),
 *)
 *
 */
class UserResponse extends \common\models\UserResponse
{
    public function fields(): array
    {
        return [
            'user_id',
            'question_id',
            'response_body',
            'user_questionnaire_uuid',
        ];
    }
}