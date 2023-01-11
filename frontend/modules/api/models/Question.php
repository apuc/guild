<?php

namespace frontend\modules\api\models;

class Question extends \common\models\Question
{
    public function fields()
    {
        return [
            'id',
            'question_type_id',
            'question_body',
            'question_priority',
            'next_question',
            'time_limit'
        ];
    }

    public function extraFields()
    {
        return [];
    }
}