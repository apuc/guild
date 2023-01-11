<?php

namespace common\services;

use frontend\modules\api\models\UserQuestionnaire;
use yii\base\InvalidConfigException;
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
    public static function calculateScore($uuid): UserQuestionnaire
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $uuid]);
        if (empty($userQuestionnaireModel)) {
            throw new NotFoundHttpException('The questionnaire with this uuid does not exist');
        }
        ScoreCalculatorService::rateResponses($userQuestionnaireModel);
        if (ScoreCalculatorService::checkAnswerFlagsForNull($userQuestionnaireModel)) {
            ScoreCalculatorService::calculateScore($userQuestionnaireModel);
        } else {
            $userQuestionnaireModel->status = 3;
            $userQuestionnaireModel->save();
        }
        return $userQuestionnaireModel;
    }
}