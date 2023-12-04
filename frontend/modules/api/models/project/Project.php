<?php

namespace frontend\modules\api\models\project;

use frontend\modules\api\models\company\Company;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;

/**
 *
 * @OA\Schema(
 *  schema="Project",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=95,
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
 *     property="owner_id",
 *     type="int",
 *     example="19",
 *     description="Идентификатор владельца проекта"
 *  ),
 *  @OA\Property(
 *     property="company",
 *     ref="#/components/schemas/Company",
 *  ),
 *  @OA\Property(
 *     property="columns",
 *     ref="#/components/schemas/ProjectColumnExample",
 *  ),
 *  @OA\Property(
 *     property="projectUsers",
 *     ref="#/components/schemas/ProjectUsersExample",
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
 *         property="owner_id",
 *         type="integer",
 *         example="19"
 *      ),
 *      @OA\Property(
 *         property="company",
 *         ref="#/components/schemas/Company",
 *      ),
 *      @OA\Property(
 *         property="projectUsers",
 *         ref="#/components/schemas/ProjectUsers",
 *      ),
 *  ),
 *)
 *
 */
class Project extends \common\models\Project
{
    const STATUS_OTHER = 19;
    const STATUS_CLOSE = 10;
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
            'owner_id',
            'company' => function() {
                return $this->company;
            },
            'projectUsers',
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return ['columns', 'mark'];
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id']);
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
