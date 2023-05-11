<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="Comment",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=12,
 *     description="Идентификатор комментария"
 *  ),
 *  @OA\Property(
 *     property="text",
 *     type="string",
 *     example="Очень хорошая задача",
 *     description="Текст комментария"
 *  ),
 *  @OA\Property(
 *     property="created_at",
 *     type="datetime",
 *     example="2023-04-07 02:09:42",
 *     description="Дата и время создания"
 *  ),
 *  @OA\Property(
 *     property="updated_at",
 *     type="datetime",
 *     example="2023-04-10 16:20:48",
 *     description="Дата и время обновления"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="integer",
 *     example=19,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="entity_type",
 *     type="int",
 *     example=2,
 *     description="Идентификатор типа сущности комментария"
 *  ),
 *  @OA\Property(
 *     property="entity_id",
 *     type="int",
 *     example=2,
 *     description="Идентификатор сущности комментария"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 *     example="1",
 *     description="Статус"
 *  ),
 *)
 *
 */
class Comment extends \common\models\Comment
{

}