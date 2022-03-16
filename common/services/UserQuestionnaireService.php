<?php

namespace common\services;

use common\models\UserQuestionnaire;
use yii\web\NotFoundHttpException;

class UserQuestionnaireService
{
    public static function getQuestionnaireList($user_id): array
    {
        $userQuestionnaireModels = UserQuestionnaire::findActiveUserQuestionnaires($user_id);
        array_walk($userQuestionnaireModels, function (&$arr) {
            unset(
                $arr['questionnaire_id'],
                $arr['created_at'],
                $arr['updated_at'],
                $arr['id'],
            );
        });
        return $userQuestionnaireModels;
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function calculateScore($user_questionnaire_uuid)
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);
        if(empty($userQuestionnaireModel)) {
            throw new NotFoundHttpException('The questionnaire with this uuid does not exist');
        }
        ScoreCalculatorService::rateResponses($userQuestionnaireModel);
        ScoreCalculatorService::calculateScore($userQuestionnaireModel);
        return $userQuestionnaireModel;
    }
}