<?php

namespace frontend\modules\api\services;

use common\helpers\UserQuestionnaireStatusHelper;
use common\services\ScoreCalculatorService;
use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class UserQuestionnaireService
{
    public static function getQuestionnaireList($user_id): array
    {
        return UserQuestionnaire::findActiveUserQuestionnaires($user_id);
    }

    /**
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public static function calculateScore($user_questionnaire_uuid): UserQuestionnaire
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);
        if (empty($userQuestionnaireModel)) {
            throw new NotFoundHttpException('The questionnaire with this uuid does not exist');
        }

       if (!in_array($userQuestionnaireModel->status, UserQuestionnaireStatusHelper::listCompleteStatuses() )) {
           ScoreCalculatorService::rateResponses($userQuestionnaireModel);
           if (ScoreCalculatorService::checkAnswerFlagsForNull($userQuestionnaireModel)) {
               ScoreCalculatorService::calculateScore($userQuestionnaireModel);
           } else {
               $userQuestionnaireModel->status = 3;
               $userQuestionnaireModel->save();
           }
       }
        return $userQuestionnaireModel;
    }

    public function checkTimeLimit(UserQuestionnaire $userQuestionnaire): bool
    {
        if (!$userQuestionnaire->start_testing) {
            $userQuestionnaire->start_testing = date('Y:m:d H:i:s');
            $userQuestionnaire->save();
        } elseif ($userQuestionnaire->questionnaire->time_limit) {
            $limitTime = strtotime($userQuestionnaire->questionnaire->time_limit) - strtotime("00:00:00");
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $startTesting = strtotime($userQuestionnaire->start_testing);

            if ($currentTime - $startTesting > $limitTime) {
                return false;
            }
        }
        return true;
    }
}