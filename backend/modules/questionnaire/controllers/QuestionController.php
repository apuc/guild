<?php

namespace backend\modules\questionnaire\controllers;

use backend\modules\questionnaire\models\AnswerSearch;
use Yii;
use backend\modules\questionnaire\models\Question;
use backend\modules\questionnaire\models\QuestionSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'as AccessBehavior' => [
                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $answerSearchModel = new AnswerSearch();
        $answerDataProvider = new ActiveDataProvider([
            'query' => $model->getAnswers(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'answerSearchModel' => $answerSearchModel,
            'answerDataProvider' => $answerDataProvider,
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($questionnaire_id = null, $question_type_id = null)
    {
        $model = new Question();
        $model->questionnaire_id = $questionnaire_id;
        $model->question_type_id = $question_type_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($questionnaire_id !== null) {
                return $this->redirect(['questionnaire/view', 'id' => $questionnaire_id]);
            }
            elseif ($question_type_id !== null) {
                return $this->redirect(['question-type/view', 'id' => $question_type_id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id, $questionnaire_id = null, $question_type_id = null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($questionnaire_id !== null) {
                return $this->redirect(['questionnaire/view', 'id' => $questionnaire_id]);
            }
            elseif ($question_type_id !== null) {
                return $this->redirect(['question-type/view', 'id' => $question_type_id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete(int $id, $questionnaire_id = null, $question_type_id = null)
    {
        $this->findModel($id)->delete();

        if ($questionnaire_id !== null) {
            return $this->redirect(['questionnaire/view', 'id' => $questionnaire_id]);
        }
        elseif ($question_type_id !== null) {
            return $this->redirect(['question-type/view', 'id' => $question_type_id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    protected function goToView($questionnaire_id = null, $question_type_id = null)
//    {
//        if ($questionnaire_id !== null)
//        {
//            return $this->redirect(['questionnaire/view', 'id' => $questionnaire_id]);
//        }
//        elseif ($question_type_id !== null)
//        {
//            return $this->redirect(['question-type/view', 'id' => $question_type_id]);
//        }
//    }
}
