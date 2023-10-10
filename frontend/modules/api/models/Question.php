<?php

namespace frontend\modules\api\models;


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
 *)
 *
 *
 * @OA\Schema(
 *  schema="QuestionExampleArr",
 *  type="array",
 *  example={
 *     {"id": "1", "question_type_id": 2, "question_body": "Вопрос 1", "question_priority": 1, "next_question": 2, "time_limit": "00:10:00",},
 *     {"id": "4", "question_type_id": 3, "question_body": "Вопрос 22", "question_priority": 4, "next_question": 5, "time_limit": "00:10:00",},
 *     },
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
 *  ),
 *)
 *
 */
class Question extends \common\models\Question
{

}