<?php

namespace frontend\modules\api\controllers;

use common\models\Answer;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;

class AnswerController extends ApiController
{
//    public function behaviors(): array
//    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['authenticator']['authMethods'] = [
//            HttpBearerAuth::className(),
//        ];
//
//        return $behaviors;
//    }

    public function verbs(): array
    {
        return [
            'get-answers' => ['get'],
        ];
    }

    /**
     * @OA\Get(path="/answer/get-answers",
     *   summary="Список ответов на вопрос",
     *   description="Получение списка ответов",
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   tags={"Tests"},
     *   @OA\Parameter(
     *      name="question_id",
     *      in="query",
     *      required=true,
     *     description="id вопроса",
     *      @OA\Schema(
     *        type="integer",
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает масив вопросов",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/AnswerExampleArr"),
     *     ),
     *
     *   ),
     * )
     *
     * @throws NotFoundHttpException
     */
    public function actionGetAnswers(): array
    {
        $question_id = Yii::$app->request->get('question_id');
        if(empty($question_id) or !is_numeric($question_id))
        {
            throw new NotFoundHttpException('Incorrect question ID');
        }

        $answers = Answer::activeAnswers($question_id);
        if(empty($answers)) {
            throw new NotFoundHttpException('Answers not found or question inactive');
        }

        array_walk( $answers, function(&$arr){
            unset(
                $arr['created_at'],
                $arr['updated_at'],
                $arr['answer_flag'],
                $arr['status']
            );
        });

        return  $answers;
    }
}
