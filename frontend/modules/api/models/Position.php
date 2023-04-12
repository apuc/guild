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
 *
 * @OA\Schema(
 *  schema="PositionsExample",
 *  type="array",
 *  example={{"id": 1, "name": "Back end - разработчик"}, {"id": 2, "name": "Front end - разработчик"}},
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="name",
 *         type="string",
 *      ),
 *  ),
 *)
 */
class Position extends \common\models\Position
{

}