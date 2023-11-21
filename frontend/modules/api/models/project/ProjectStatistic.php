<?php

namespace frontend\modules\api\models\project;

use frontend\modules\api\models\Company;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;

/**
 *
 * @OA\Schema(
 *  schema="ProjectStatistic",
 *  @OA\Property(
 *     property="creator",
 *     ref="#/components/schemas/ProjectParticipants",
 *  ),
 *  @OA\Property(
 *     property="open_tasks_count",
 *     type="int",
 *     example="10",
 *  ),
 *  @OA\Property(
 *     property="task_on_work_count",
 *     type="int",
 *     example="15",
 *  ),
 *  @OA\Property(
 *     property="closed_task_count",
 *     type="int",
 *     example="234",
 *  ),
 *  @OA\Property(
 *     property="participants",
 *     ref="#/components/schemas/ProjectParticipants",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ProjectStatisticExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="creator",
 *         ref="#/components/schemas/ProjectParticipantsExample",
 *      ),
 *      @OA\Property(
 *         property="open_tasks_count",
 *         type="int",
 *         example="10"
 *      ),
 *      @OA\Property(
 *         property="task_on_work_count",
 *         type="int",
 *         example="15"
 *      ),
 *      @OA\Property(
 *         property="closed_task_count",
 *         type="integer",
 *         example="324"
 *      ),
 *      @OA\Property(
 *         property="participants",
 *         ref="#/components/schemas/ProjectParticipantsExampleArr",
 *      ),
 *  ),
 *)
 *
 *
 * @property Company $company
 * @property ProjectParticipants $owner
 * @property ProjectUser[] $participants
 */
class ProjectStatistic extends \common\models\Project
{

    public function fields(): array
    {
        return [
            'creator' => function () {
                return $this->owner;
            },
            'open_tasks_count'=> function () {
                return $this->getProjectTask()->where(['status' => ProjectTask::STATUS_ACTIVE])->count();
            },
            'task_on_work_count'=> function () {
                return $this->getProjectTask()->where(['status' => ProjectTask::STATUS_AT_WORK])->count();
            },
            'closed_task_count'=> function () {
                return $this->getProjectTask()->where(['status' => ProjectTask::STATUS_ARCHIVE])->count();
            },
            'participants'=> function () {
                return $this->participants;
            },
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [];
    }

    /**
     * @return ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(ProjectParticipants::class, ['id' => 'owner_id']);
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
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getParticipants()
    {
        return $this->hasMany(ProjectParticipants::class, ['project_id' => 'id']);
    }
}
