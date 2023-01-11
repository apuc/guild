<?php

namespace frontend\modules\api\controllers;

use common\helpers\UUIDHelper;
use common\models\UserQuestionnaire;
use frontend\modules\api\models\Question;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class QuestionController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'get-questions' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionGetQuestions(): array
    {
        $uuid = Yii::$app->request->get('uuid');

        if(empty($uuid) or !UUIDHelper::is_valid($uuid))
        {
            throw new NotFoundHttpException('Incorrect questionnaire UUID');
        }

        $questionnaire_id = UserQuestionnaire::getQuestionnaireId($uuid);

        $questions = Question::activeQuestions($questionnaire_id);
        if(empty($questions)) {
            throw new NotFoundHttpException('Questions not found');
        }

        return  $questions;
    }

}
