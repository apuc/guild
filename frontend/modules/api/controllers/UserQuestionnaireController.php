<?php

namespace frontend\modules\api\controllers;

use common\services\UserQuestionnaireService;
use frontend\modules\api\models\UserQuestionnaire;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserQuestionnaireController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'questionnaires-list' => ['get'],
                    'questionnaire-completed' => ['get'],
                    'get-points-number' => ['get'],
                    'get-question-number' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionQuestionnairesList($user_id = null): array
    {
        $user_id = $user_id ?? Yii::$app->user->id;
        if (!is_numeric($user_id)) {
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
     * @throws \yii\base\InvalidConfigException
     */
    public function actionQuestionnaireCompleted($uuid): UserQuestionnaire
    {
        $userQuestionnaireModel = UserQuestionnaireService::calculateScore($uuid);
        if ($userQuestionnaireModel->errors) {
            throw new ServerErrorHttpException($userQuestionnaireModel->errors);
        }
        return $userQuestionnaireModel;
    }
}
