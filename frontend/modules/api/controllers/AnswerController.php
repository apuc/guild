<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Answer;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AnswerController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'get-answers' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetAnswers($question_id): array
    {
        if(empty($question_id) or !is_numeric($question_id))
        {
            throw new NotFoundHttpException('Incorrect question ID');
        }

        $answers = Answer::activeAnswers($question_id);
        if(empty($answers)) {
            throw new NotFoundHttpException('Answers not found or question inactive');
        }
        return  $answers;
    }
}
