<?php

namespace frontend\modules\api\models;

/**
 * @OA\Schema(
 *  schema="Timer",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=12,
 *     description="Идентификатор таймера"
 *  ),
 *  @OA\Property(
 *     property="created_at",
 *     type="datetime",
 *     example="2023-04-07 02:09:42",
 *     description="Дата и время создания"
 *  ),
 *  @OA\Property(
 *     property="stopped_at",
 *     type="datetime",
 *     example="2023-04-10 16:20:48",
 *     description="Дата и время остановки"
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
 *     description="Идентификатор типа сущности таймера"
 *  ),
 *  @OA\Property(
 *     property="entity_id",
 *     type="int",
 *     example=2,
 *     description="Идентификатор сущности таймера"
 *  ),
 *  @OA\Property(
 *     property="deltaSeconds",
 *     type="int",
 *     example=547,
 *     description="Время между началом и завершением таймера в секундах"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 *     example="1",
 *     description="Статус"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="TimerExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/Timer",
 *  ),
 *)
 *
 */
class Timer extends \common\models\Timer
{

}