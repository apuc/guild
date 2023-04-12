<?php

namespace frontend\modules\api\models;
/**
 * @OA\Schema(
 *  schema="Skill",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор навыка"
 *  ),
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     example="PHP",
 *     description="Название навыка"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="SkillsExample",
 *  type="array",
 *  example={{"id": 1, "name": "PHP"}, {"id": 2, "name": "Yii2"}},
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
class Skill extends \common\models\Skill
{

}