<?php

namespace frontend\modules\api\models;

/**
 *
 * @OA\Schema(
 *  schema="Company",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор компании"
 *  ),
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     example="OhDesign",
 *     description="Название компании"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     example="Компания разрабатывает сайт для дизайнеров",
 *     description="Описание компании"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="CompanyExample",
 *  type="array",
 *  example={{"id": 1, "name": "GoDesigner", "description": "Сайт для дизайнеров"}, {"id": 2, "name": "PR Holding", "description": "Сайт для маркетологов"}},
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
 *      @OA\Property(
 *         property="description",
 *         type="string",
 *      ),
 *  ),
 *)
 *
 */
class Company extends \common\models\Company
{
    public function fields()
    {
        return [
            'id',
            'name',
            'description',
        ];
    }

    public function extraFields(): array
    {
        return [];
    }
}
