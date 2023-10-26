<?php

namespace frontend\modules\api\controllers;

use common\helpers\UUIDHelper;
use common\models\Question;
use common\models\UserQuestionnaire;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class QuestionController extends ApiController
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
     * @OA\Get(path="/question/get-questions",
     *   summary="Список вопросов",
     *   description="Получение списка вопросов",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="uuid",
     *      in="query",
     *      required=true,
     *     description="UUID анкеты назначеной пользователю",
     *      @OA\Schema(
     *        type="string",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает масив вопросов",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/QuestionExampleArr"),
     *     ),
     *
     *
     *   ),
     * )
     *
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
