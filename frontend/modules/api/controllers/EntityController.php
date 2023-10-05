<?php

namespace frontend\modules\api\controllers;

use common\models\Entity;
use frontend\modules\api\models\Comment;

class EntityController extends ApiController
{
    /**
     * @return array[]
     */
    public function verbs(): array
    {
        return [
            'get-list' => ['get'],
        ];
    }


    /**
     *
     * @OA\Get(path="/entity/get-list",
     *   summary="Список типов сущностей",
     *   description="Получить список всех возможных типов сущностей",
     *   tags={"Entity"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="1",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Проект",
     *                 ),
     *             )
     *         ),
     *     ),
     *
     *   ),
     * )
     *
     * @return array
     */
    public function actionGetList(): array
    {
        $arr = [];
        foreach (Entity::getEntityTypeList() as $key => $value) {
            $arr[] = ["id" => $key, "name" => $value];
        }

        return $arr;
    }


}