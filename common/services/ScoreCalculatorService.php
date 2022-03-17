<?php

namespace common\services;

use backend\modules\questionnaire\models\Answer;
use common\models\UserQuestionnaire;
use common\models\UserResponse;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class ScoreCalculatorService
{
    public static function rateResponses(UserQuestionnaire $user_questionnaire)
    {
        $responses = $user_questionnaire->getUserResponses()->all();

        foreach ($responses as $response) {
            self::rateOneResponse($response);
        }
    }

    public static function rateOneResponse(UserResponse $response)
    {
        if ($response->getQuestionTypeValue() != 1) {  // not open question
            $correct_answers = $response->getCorrectAnswers();
            foreach ($correct_answers as $correct_answer) {
                if ($response->response_body === $correct_answer['answer_body']) {
                    $response->answer_flag = 1;
                    $response->save();
                    return;
                }
            }
            $response->answer_flag = 0;
            $response->save();
        }
    }

    public static function checkAnswerFlagsForNull(UserQuestionnaire $userQuestionnaire): bool
    {
        $responses = $userQuestionnaire->getUserResponses()->AsArray()->all();
        foreach ($responses as $response) {
            if (ArrayHelper::isIn(null, $response))
                return false;
        }
        return true;
    }

    /**
     * @throws InvalidConfigException
     */
    public static function calculateScore(UserQuestionnaire $userQuestionnaire)
    {
        $responses_questions = $userQuestionnaire->hasMany(UserResponse::className(), ['user_questionnaire_uuid' => 'uuid'])
            ->joinWith('question')->asArray()->all();

        $score = null;
        $user_correct_answers_num = null;
        foreach ($responses_questions as $response_question) {
            if(self::isCorrect($response_question['answer_flag'])) {
                $user_correct_answers_num += 1;
                switch ($response_question['question']['question_type_id']) {
                    case '1':  // open question
                        $score += $response_question['answer_flag'] * $response_question['question']['score'];
                        break;
                    case '2':  // one answer
                        $score += $response_question['question']['score'];
                        break;
                    case '3':  // multi answer
                        $score += $response_question['question']['score'] / self::correctAnswersNum($response_question['question']['id']);
                        break;
                    case '4':  // istina-loz
                        $score += $response_question['question']['score'];
                        break;
                }
            }
        }

        self::setPercentCorrectAnswers($user_correct_answers_num, $userQuestionnaire);
        $userQuestionnaire->score = round($score);
        $userQuestionnaire->status = 2;
        $userQuestionnaire->testing_date = date('Y:m:d H:i:s');
        $userQuestionnaire->save();
    }

    protected static function isCorrect($answer_flag): bool
    {
        if ($answer_flag > 0) {
            return true;
        }
        return false;
    }

    protected static function correctAnswersNum($question_id)
    {
        return Answer::numCorrectAnswers($question_id);
    }

    /**
     * @throws InvalidConfigException
     */
    protected static function setPercentCorrectAnswers($user_correct_answers_num, UserQuestionnaire $userQuestionnaire)
    {
        if($user_correct_answers_num !== null) {
            $all_correct_answers_num = $userQuestionnaire->numCorrectAnswersWithoutOpenQuestions();
            $all_correct_answers_num += $userQuestionnaire->numOpenQuestionsAnswers();

            $percent = $user_correct_answers_num / $all_correct_answers_num;
            $userQuestionnaire->percent_correct_answers = round($percent, 2);
        }
        else {
            $userQuestionnaire->percent_correct_answers = round($user_correct_answers_num, 2);
        }
    }
}