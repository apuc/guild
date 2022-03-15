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
}
