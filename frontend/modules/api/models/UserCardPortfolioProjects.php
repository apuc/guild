<?php

namespace frontend\modules\api\models;


/**
 *
 * @OA\Schema(
 *  schema="UserCardPortfolioProjects",
 *  @OA\Property(
 *     property="title",
 *     type="string",
 *     description="Название"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     description="Описание проекта"
 *  ),
 *  @OA\Property(
 *     property="main_stack",
 *     type="string",
 *     description="Основная технология"
 *  ),
 *  @OA\Property(
 *     property="additional_stack",
 *     type="string",
 *     description="Дополнительные технологии"
 *  ),
 *  @OA\Property(
 *     property="link",
 *     type="string",
 *     description="Ссылка"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="UserCardPortfolioProjectsExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/UserCardPortfolioProjects",
 *  ),
 *)
 *
 * @property Skill $mainStack
 */
class UserCardPortfolioProjects extends \common\models\UserCardPortfolioProjects
{
    public function fields(): array
    {
        return [
            'title',
            'description',
            'main_stack' => function () {
                return $this->mainStack->name;
            },
            'additional_stack',
            'link',
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [];
    }

    public function getMainStack()
    {
        return $this->hasOne(Skill::class, ['id' => 'main_stack']);
    }
}
