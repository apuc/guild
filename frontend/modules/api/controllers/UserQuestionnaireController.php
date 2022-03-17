<?php

namespace frontend\modules\api\controllers;

use common\services\UserQuestionnaireService;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserQuestionnaireController extends ApiController
{
    public function verbs()
    {
        return [
            'questionnaires-list' => ['get'],
            'questionnaire-completed' => ['get'],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionQuestionnairesList($user_id): array
    {
        if (empty($user_id) or !is_numeric($user_id)) {
            throw new NotFoundHttpException('Incorrect user ID');
        }
        $userQuestionnaireModels = UserQuestionnaireService::getQuestionnaireList($user_id);
        if(empty($userQuestionnaireModels)) {
            throw new NotFoundHttpException('Active questionnaire not found');
        }
        return $userQuestionnaireModels;
    }

    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionQuestionnaireCompleted($user_questionnaire_uuid)
    {
        $userQuestionnaireModel = UserQuestionnaireService::calculateScore($user_questionnaire_uuid);
        if ($userQuestionnaireModel->errors) {
            throw new ServerErrorHttpException(json_encode($userQuestionnaireModel->errors));
        }
        return $userQuestionnaireModel;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionGetPointsNumber($user_questionnaire_uuid)
    {
        $questionPointsNumber = UserQuestionnaireService::getPointsNumber($user_questionnaire_uuid);
        if (empty($questionPointsNumber)) {
            throw new ServerErrorHttpException(json_encode('Question points not found!'));
        }
        return $questionPointsNumber;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionGetQuestionNumber($user_questionnaire_uuid)
    {
        $questionNumber = UserQuestionnaireService::getQuestionNumber($user_questionnaire_uuid);
        if (empty($questionNumber)) {
            throw new ServerErrorHttpException(json_encode('Question number not found!'));
        }
        return $questionNumber;
    }
}
