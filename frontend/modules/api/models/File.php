<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="File",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор файла"
 *  ),
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     example="image.png",
 *     description="Имя файла"
 *  ),
 *  @OA\Property(
 *     property="path",
 *     type="string",
 *     example="/frontend/web/files/c3/8b/c38bf511e3082e3021bed1572c2c8144.png",
 *     description="Путь к файлу"
 *  ),
 *  @OA\Property(
 *     property="url",
 *     type="string",
 *     example="/files/c3/8b/c38bf511e3082e3021bed1572c2c8144.png",
 *     description="URL файла"
 *  ),
 *  @OA\Property(
 *     property="type",
 *     type="string",
 *     example="png",
 *     description="Расширение файла"
 *  ),
 *  @OA\Property(
 *     property="mime-type",
 *     type="string",
 *     example="image/png",
 *     description="Mime-type файла"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 *     example=1,
 *     description="Статус файла"
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="FileExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/File",
 *  ),
 *)
 *
 */
class File extends \common\models\File
{

}