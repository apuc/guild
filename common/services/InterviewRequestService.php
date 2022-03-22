<?php

namespace common\services;

use common\models\InterviewRequest;
use Yii;

class InterviewRequestService
{
    public static function createInterviewRequest($interviewRequestParams)
    {
        $interviewRequest = new InterviewRequest();
        $attributes = $interviewRequestParams;

        $interviewRequest->attributes = $attributes;

        $interviewRequest->created_at = time();
        $interviewRequest->user_id = \Yii::$app->user->id;

        if ($interviewRequest->save()) {
            \Yii::$app->telegram_bot->sendRenderedMessage('interview_request', $attributes);
        }

        return $interviewRequest;
    }

}