<?php

namespace frontend\modules\api\models;

use common\models\Question;

class UserQuestionnaire extends \common\models\UserQuestionnaire
{
    public function fields()
    {
        return [
            'questionnaire_title' => function() {
                return $this->questionnaire->title;
            },
            'uuid',
            'created_at',
            'score',
            'status',
            'percent_correct_answers',
            'testing_date'
        ];
    }

    public function extraFields()
    {
        return [
            'question_number' => function() {
                return Question::find()
                    ->where(['questionnaire_id' => $this->questionnaire->id])
                    ->andWhere(['status' => 1])
                    ->count();
            },
            'points_number' => function() {
                return Question::find()
                    ->where(['questionnaire_id' => $this->questionnaire->id])
                    ->andWhere(['status' => 1])
                    ->sum('score');
            }
        ];
    }
}