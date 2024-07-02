<?php

namespace frontend\modules\api\models;

/**
 * @OA\Schema(
 *  schema="Tgparsing",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор поста"
 *  ),
 *  @OA\Property(
 *     property="channel_id",
 *     type="int",
 *     example=32452345,
 *     description="Идентификатор канала"
 *  ),
 *  @OA\Property(
 *     property="channel_title",
 *     type="string",
 *     example="Какой-то канал",
 *     description="Название канала"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example=1,
 *     description="Статус поста"
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
 *     example="2023-04-07 02:09:42",
 *     description="Дата и время редактирования"
 *  ),
 *)
 */
class Tgparsing extends \common\models\Tgparsing
{

}