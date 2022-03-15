<?php

namespace frontend\modules\api\controllers;

use common\helpers\ScoreCalculatorHelper;
use common\models\UserQuestionnaire;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class UserQuestionnaireController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

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
    public function actionQuestionnairesList()//: array
    {
        $user_id = Yii::$app->request->get('user_id');

        if(empty($user_id) or !is_numeric($user_id))
        {
            throw new NotFoundHttpException('Incorrect user ID');
        }

        $userQuestionnaireModels = UserQuestionnaire::findActiveUserQuestionnaires($user_id);
        if(empty($userQuestionnaireModels)) {
            throw new NotFoundHttpException('Active questionnaire not found');
        }

        array_walk( $userQuestionnaireModels, function(&$arr){
            unset(
                $arr['questionnaire_id'],
//                $arr['created_at'],
//                $arr['updated_at'],
                $arr['id'],
            );
        });

        return  $userQuestionnaireModels;
    }

    public function actionQuestionnaireCompleted()
    {
//        return Yii::$app->request;
        $user_questionnaire_uuid = Yii::$app->request->get('user_questionnaire_uuid');

        if(empty($user_questionnaire_uuid))
        {
            throw new NotFoundHttpException('Incorrect user ID');
        }

        $userQuestionnaireModel = UserQuestionnaire::findOne(['uuid' => $user_questionnaire_uuid]);

        if(empty($userQuestionnaireModel)) {
            throw new NotFoundHttpException('Active questionnaire not found');
        }

        ScoreCalculatorHelper::rateResponses($userQuestionnaireModel);
        ScoreCalculatorHelper::calculateScore($userQuestionnaireModel);

        return $userQuestionnaireModel;
    }
}
