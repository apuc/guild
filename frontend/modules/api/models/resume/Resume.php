<?php

namespace frontend\modules\api\models\resume;

use frontend\modules\card\models\UserCard;

/**
 *
 * @OA\Schema(
 *  schema="Resume",
 *  type="array",
 *  @OA\Items(
 *  @OA\Property(
 *     property="fio",
 *     type="string",
 *     example="ФИО",
 *     description="ФИО"
 *  ),
 *  @OA\Property(
 *     property="position",
 *     type="string",
 *     example="position",
 *     description="Специализация"
 *  ),
 *  @OA\Property(
 *     property="stack",
 *     type="array",
 *     @OA\Items(
 *         type="string",
 *     ),
 *     example="[Yii2,Vue]",
 *     description="Основной стек"
 *  ),
 *  @OA\Property(
 *     property="resume",
 *     type="string",
 *     example="Резюме",
 *     description="Тело резюме в HTML разметке"
 *  ),
 *  @OA\Property(
 *     property="projects",
 *      ref="#/components/schemas/UserCardPortfolioProjectsExample",
 *  ),
 *     ),
 *)
 *
 * @OA\Schema(
 *  schema="ResumeExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/Resume",
 *  ),
 *)
 * @property UserCard $userCard
 */
class Resume extends \common\models\User
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'fio' => function () {
                return $this->userCard->fio;
            },
            'position' => function () {
                return $this->userCard->position->name;
            },
            'stack' => function () {
                return $this->userCard->getSkillsName();

            },
            'resume' => function () {
                return $this->userCard->vc_text;
            },
            'projects' => function () {
                return $this->userCard->userCardPortfolioProjects;
            },
        ];
    }

    public function getUserCard()
    {
        return $this->hasOne(UserCard::class, ['id_user' => 'id']);
    }
}