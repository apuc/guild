<?php

namespace common\services;

use common\models\Question;
use common\models\UserQuestionnaire;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

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
     * @throws InvalidConfigException
     */
    public static function calculateScore($user_questionnaire_uuid): UserQuestionnaire
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);
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

    /**
     * @throws ServerErrorHttpException
     */
    public static function getQuestionNumber($user_questionnaire_uuid): array
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);
        if (empty($userQuestionnaireModel)) {
            throw new ServerErrorHttpException(json_encode('Not found UserQuestionnaire'));
        }
        $count = Question::find()
            ->where(['questionnaire_id' => $userQuestionnaireModel->questionnaire_id])
            ->andWhere(['status' => 1])
            ->count();
        return array('question_number' => $count);
    }

    /**
     * @throws ServerErrorHttpException
     */
    public static function getPointsNumber($user_questionnaire_uuid)
    {
        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);
        if (empty($userQuestionnaireModel)) {
            throw new ServerErrorHttpException(json_encode('Not found UserQuestionnaire'));
        }
        $pointSum = Question::find()
            ->where(['questionnaire_id' => $userQuestionnaireModel->questionnaire_id])
            ->andWhere(['status' => 1])
            ->sum('score');
        return array('sum_point' => $pointSum);
    }
}