<?php

namespace frontend\modules\api\models;

/**
 * @OA\Schema(
 *  schema="Reports",
 *  @OA\Property(
 *     property="difficulties",
 *     type="string",
 *     description="Описание сложностей возникших при выполнении задач"
 *  ),
 *  @OA\Property(
 *     property="tomorrow",
 *     type="string",
 *     description="Описание планов на завтра"
 *  ),
 *
 *  @OA\Property(
 *     property="created_at",
 *     type="datetime",
 *     example="2023-04-07 02:09:42",
 *     description="Дата создания"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="integer",
 *     example="1",
 *     description="Статус"
 *  ),
 *  @OA\Property(
 *     property="user_card_id",
 *     type="integer",
 *     example=19,
 *     description="ID карты(профиля) пользователя"
 *  ),
 *  @OA\Property(
 *     property="user_id",
 *     type="integer",
 *     example=23,
 *     description="ID пользователя"
 *  ),
 *  @OA\Property(
 *     property="project_id",
 *     type="integer",
 *     example=1,
 *     description="ID проекта"
 *  ),
 *  @OA\Property(
 *     property="company_id",
 *     type="integer",
 *     example=1,
 *     description="ID компании",
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="ReportsResponseCreateExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="difficulties",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="tomorrow",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="created_at",
 *         type="datetime",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user_card_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="project_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="company_id",
 *         type="integer",
 *      ),
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="ReportsResponseExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="difficulties",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="tomorrow",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="created_at",
 *         type="datetime",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user_card_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="project_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="company_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="task",
 *         ref="#/components/schemas/ProjectTaskReportsExample",
 *      ),
 *      @OA\Property(
 *         property="project",
 *         ref="#/components/schemas/ProjectExample",
 *      ),
 *  ),
 *)
 *
 */
class Reports extends \common\models\Reports
{

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'difficulties',
            'tomorrow',
            'created_at',
            'status',
            'user_card_id',
            'user_id',
            'project_id',
            'project',
            'company_id',
            'task',
        ];
    }

}