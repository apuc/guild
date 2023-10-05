<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="MarkEntity",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор метки"
 *  ),
 *  @OA\Property(
 *     property="mark_id",
 *     type="integer",
 *     example=1,
 *     description="Идентификатор метки"
 *  ),
 *  @OA\Property(
 *     property="mark",
 *     ref="#/components/schemas/MarkExample",
 *     description="Файл"
 *  ),
 *  @OA\Property(
 *     property="entity_type",
 *     type="integer",
 *     example=2,
 *     description="Идентификатор типа сущности"
 *  ),
 *  @OA\Property(
 *     property="entity_id",
 *     type="integer",
 *     example=24,
 *     description="Идентификатор сущности"
 *  ),
 *)
 *
 */
class MarkEntity extends \common\models\MarkEntity
{

}