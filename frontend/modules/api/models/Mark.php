<?php

namespace frontend\modules\api\models;


/**
 *
 * @OA\Schema(
 *  schema="Mark",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=12,
 *     description="Идентификатор метки"
 *  ),
 *  @OA\Property(
 *     property="title",
 *     type="string",
 *     example="Срочная задача",
 *     description="Описание метки"
 *  ),
 *  @OA\Property(
 *     property="slug",
 *     type="string",
 *     example="urgent",
 *     description="Ключ метки"
 *  ),
 *  @OA\Property(
 *     property="color",
 *     type="string",
 *     example="RED",
 *     description="Цвет метки"
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
 *  schema="MarkExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/Mark",
 *  ),
 *)
 *
 */
class Mark extends \common\models\Mark
{

}