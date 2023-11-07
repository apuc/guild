<?php

namespace frontend\modules\api\models\resume;

use yii\helpers\ArrayHelper;

/**
 *
 * @OA\Schema(
 *  schema="Resume",
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
 *)
 *
 * @OA\Schema(
 *  schema="ResumeExample",
 *  type="array",
 *  @OA\Items(
 *     ref="#/components/schemas/Resume",
 *  ),
 *)
 */
class Resume extends \common\models\User
{

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'stack' => function() {
                return $this->userCard->getSkillsName();

            },
            'resume' => function () {
                return $this->userCard->vc_text;
            },
        ];
    }
}