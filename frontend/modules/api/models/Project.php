<?php

namespace frontend\modules\api\models;

use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 *
 * @OA\Schema(
 *  schema="Project",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор проекта"
 *  ),
 *  @OA\Property(
 *     property="name",
 *     type="string",
 *     example="PHP",
 *     description="Название проекта"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="10",
 *     description="Статус проекта"
 *  ),
 *  @OA\Property(
 *     property="hh_id",
 *     type="int",
 *     example="234",
 *     description="Идентификатор проекта на hh.ru"
 *  ),
 *  @OA\Property(
 *     property="company",
 *     ref="#/components/schemas/Company",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         example="1"
 *      ),
 *      @OA\Property(
 *         property="name",
 *         type="string",
 *         example="OhDesign - backend"
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="integer",
 *         example="10"
 *      ),
 *      @OA\Property(
 *         property="hh_id",
 *         type="integer",
 *         example="345343434"
 *      ),
 *      @OA\Property(
 *         property="company",
 *         ref="#/components/schemas/Company",
 *      ),
 *  ),
 *)
 *
 */
class Project extends \common\models\Project
{
    public function fields(): array
    {
        return [
            'id',
            'name',
            //'budget',
            'status',
            'hh_id' => function() {
                return $this->hh;
            },
            'company' => function() {
                return $this->company;
            }
        ];
    }

    public function extraFields(): array
    {
        return [];
    }

    public function getLinks(): array
    {
        return [
            Link::REL_SELF => Url::to(['index', 'project_id' => $this->id], true),
        ];
    }

    public function getCompany(): ActiveQuery
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
