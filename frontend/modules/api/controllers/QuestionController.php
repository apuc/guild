<?php

namespace frontend\modules\api\controllers;

use common\models\Question;
use common\models\Questionnaire;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;

class QuestionController extends \yii\rest\Controller
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
            'get-questions' => ['get'],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetQuestions()
    {
        $questionnaire_id = Yii::$app->request->get('questionnaire_id');

        if(empty($questionnaire_id) or !is_numeric($questionnaire_id))
        {
            throw new NotFoundHttpException('Incorrect questionnaire ID');
        }

        $questions = Question::getActiveQuestions($questionnaire_id);
        if(empty($questions)) {
            throw new NotFoundHttpException('Active questionnaire not found');
        }

        array_walk( $questions, function(&$arr){
            unset(
                $arr['score'],
                $arr['created_at'],
                $arr['updated_at'],
                $arr['status'],
            );
        });

        return  $questions;
    }

}
