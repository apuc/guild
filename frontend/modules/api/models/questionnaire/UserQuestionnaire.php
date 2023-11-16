<?php

namespace frontend\modules\api\models\questionnaire;


/**
 *
 * @OA\Schema(
 *  schema="UserQuestionnaire",
 *  @OA\Property(
 *     property="user_id",
 *     type="int",
 *     example=1,
 *     description="Идентификатор пользователя"
 *  ),
 *  @OA\Property(
 *     property="uuid",
 *     type="string",
 *     example="d222f858-60fd-47fb-8731-dc9d5fc384c5",
 *     description="uuid"
 *  ),
 *  @OA\Property(
 *     property="score",
 *     type="int",
 *     example="11",
 *     description="Количество балов за тест"
 *  ),
 *  @OA\Property(
 *     property="status",
 *     type="int",
 *     example="2",
 *     description="статус файла"
 *  ),
 *  @OA\Property(
 *     property="percent_correct_answers",
 *     type="float",
 *     example="0.25",
 *     description="Процент правильных ответов"
 *  ),
 *  @OA\Property(
 *     property="testing_date",
 *     type="string",
 *     example="2022-03-17 11:14:22",
 *     description="Дата тестирования"
 *  ),
 *  @OA\Property(
 *     property="questionnaire_title",
 *     type="string",
 *     example="Анкета 1",
 *     description="Название анкеты"
 *  ),
 *  @OA\Property(
 *     property="description",
 *     type="string",
 *     example="Анкета 1",
 *     description="Описание теста"
 *  ),
 *  @OA\Property(
 *     property="points_number",
 *     type="int",
 *     example="80",
 *     description="Количество балов"
 *  ),
 *  @OA\Property(
 *     property="number_questions",
 *     type="int",
 *     example="21",
 *     description="Количество вопросов"
 *  ),
 *  @OA\Property(
 *     property="time_limit",
 *     type="string",
 *     example="00:50:00",
 *     description="Лимит времени на выполнение"
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="UserQuestionnaireExample",
 *  type="array",
 *  @OA\Items(
 *      type="object",
 *      ref="#/components/schemas/UserQuestionnaire",
 *  ),
 *)
 *
 * @OA\Schema(
 *  schema="UserQuestionnaireArrExample",
 *  type="array",
 *  example={
 *     {"uuid": "d222f858-60fd-47fb-8731-dc9d5fc384c5", "score": 11, "status": 2, "percent_correct_answers": 0.25, "testing_date": "2022-04-03 09:23:45", "questionnaire_title": "Тест 2", "description": "Описание", "points_number": "22", "number_questions": "15", "time_limit": "00:50:00"},
 *     {"uuid": "gcjs77d9-vtyd-02jh-9467-dc8fbb6s6jdb", "score": 20, "status": 2, "percent_correct_answers": 0.85, "testing_date": "2022-03-17 11:14:22", "questionnaire_title": "Тест 1", "description": "Описание", "points_number": "80", "number_questions": "35", "time_limit": "01:10:00"},
 *     },
 *  @OA\Items(
 *      type="object",
 *      @OA\Property(
 *         property="uuid",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="score",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="integer",
 *      ),
 *      @OA\Property(
 *         property="percent_correct_answers",
 *         type="float",
 *      ),
 *     @OA\Property(
 *         property="testing_date",
 *         type="string",
 *      ),
 *     @OA\Property(
 *         property="questionnaire_title",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="description",
 *         type="string",
 *      ),
 *      @OA\Property(
 *         property="points_number",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="number_questions",
 *         type="int",
 *      ),
 *      @OA\Property(
 *         property="time_limit",
 *         type="string",
 *      ),
 *  ),
 *)
 *
 */
class UserQuestionnaire extends \common\models\UserQuestionnaire
{
    public function fields(): array
    {
        return [
            'user_id',
            'uuid',
            'score',
            'status',
            'percent_correct_answers',
            'testing_date',
            'questionnaire_title' => function () {
                return $this->questionnaire->title;
            },
            'description' => function () {
                return $this->questionnaire->description;
            },
            'points_number' => function () {
                return Question::find()
                    ->where(['questionnaire_id' => $this->questionnaire_id])
                    ->andWhere(['status' => 1])
                    ->sum('score');
            },
            'number_questions' => function () {
                return Question::find()
                    ->where(['questionnaire_id' => $this->questionnaire_id])
                    ->andWhere(['status' => 1])
                    ->count();
            },
            'time_limit' => function () {
                return $this->questionnaire->time_limit;
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
}