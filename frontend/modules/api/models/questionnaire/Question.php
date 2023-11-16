<?php

namespace frontend\modules\api\models\questionnaire;

use yii\db\ActiveQuery;

/**
 *
 * @OA\Schema(
 *  schema="Question",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор вопроса"
 *  ),
 *  @OA\Property(
 *     property="question_type_id",
 *     type="int",
 *     example="2",
 *     description="Тип вопроса: 1 - Открытый вопрос; 2 - Один правильный ответ; 3 - Несколько вариантов ответа; 4 - 'Истина - ложь'"
 *  ),
 *  @OA\Property(
 *     property="question_body",
 *     type="string",
 *     example="Вопрос №1",
 *     description="Тело вопроса"
 *  ),
 *  @OA\Property(
 *     property="question_priority",
 *     type="int",
 *     example="2",
 *     description="Приоритет вопроса"
 *  ),
 *  @OA\Property(
 *     property="next_question",
 *     type="int",
 *     example="5",
 *     description="Следующий вопрос"
 *  ),
 *  @OA\Property(
 *     property="time_limit",
 *     type="string",
 *     example="00:22:00",
 *     description="Лимит времени на ответ"
 *  ),
 *  @OA\Property(
 *     property="result_profiles",
 *     ref="#/components/schemas/AnswerExampleArr",
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="QuestionExampleArr",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="question_type_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="question_body",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="question_priority",
 *         type="integer",
 *      ),
 *     @OA\Property(
 *         property="next_question",
 *         type="integer",
 *      ),
 *     @OA\Property(
 *         property="time_limit",
 *         type="string",
 *      ),
 *     @OA\Property(
 *         property="result_profiles",
 *         ref="#/components/schemas/AnswerExampleArr",
 *      ),
 *  ),
 *)
 *
 * @property Answer[] $answers
 */
class Question extends \common\models\Question
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'question_type_id',
            'question_body',
            'question_priority',
            'next_question',
            'time_limit',
            'answers' => function () {
                return $this->answers;
            }
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
    public function getAnswers(): ActiveQuery
    {
        return $this->hasMany(Answer::class, ['question_id' => 'id']);
    }
}