<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="FileEntity",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор файла"
 *  ),
 *  @OA\Property(
 *     property="file_id",
 *     type="integer",
 *     example=232,
 *     description="Идентификатор файла"
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
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 *     example=1,
 *     description="Статус прикрепления"
 *  ),
 *)
 *
 */
class FileEntity extends \common\models\FileEntity
{

}