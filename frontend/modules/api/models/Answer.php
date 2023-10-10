<?php

namespace frontend\modules\api\models;


/**
 *
 * @OA\Schema(
 *  schema="Answer",
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор ответа"
 *  ),
 *  @OA\Property(
 *     property="question_id",
 *     type="int",
 *     example="7",
 *     description="Идентификатор вопроса"
 *  ),
 *  @OA\Property(
 *     property="question_body",
 *     type="string",
 *     example="Вопрос №1",
 *     description="Тело вопроса"
 *  ),
 *)
 *
 *
 * @OA\Schema(
 *  schema="AnswerExampleArr",
 *  type="array",
 *  example={
 *     {"id": "1", "question_id": 2, "question_body": "Ответ 1",},
 *     {"id": "4", "question_id": 3, "question_body": "Ответ 22",},
 *     },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="question_id",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="question_body",
 *         type="string",
 *      ),
 *  ),
 *)
 *
 */
class Answer extends \common\models\Answer
{

}