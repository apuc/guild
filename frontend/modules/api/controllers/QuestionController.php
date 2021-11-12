<?php

namespace frontend\modules\api\controllers;

use common\helpers\UUIDHelper;
use common\models\Question;
use common\models\UserQuestionnaire;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
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

        array_walk( $questions, function(&$arr){
            unset(
                $arr['score'],
                $arr['created_at'],
                $arr['updated_at'],
                $arr['status'],
                $arr['questionnaire_id']
            );
        });

        return  $questions;
    }

}
