<?php

namespace frontend\modules\api\models;

/**
 * @OA\Schema(
 *  schema="Position",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор позиции"
 *  ),
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     example="Back end - разработчик",
 *     description="Название позиции"
 *  ),
 *)
 */
class Position extends \common\models\Position
{

}