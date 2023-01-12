<?php


namespace frontend\modules\api\models;

class Answer extends \common\models\Answer
{
    public function fields()
    {
        return [
            'id',
            'question_id',
            'answer_body'
        ];
    }

    public function extraFields()
    {
        return [];
    }
}