<?php

namespace backend\modules\questionnaire\controllers;

use backend\modules\questionnaire\models\Questionnaire;
use backend\modules\questionnaire\models\QuestionnaireCategory;
use common\helpers\ScoreCalculatorHelper;
use Yii;
use backend\modules\questionnaire\models\UserQuestionnaire;
use backend\modules\questionnaire\models\UserQuestionnaireSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * UserQuestionnaireController implements the CRUD actions for UserQuestionnaire model.
 */
class UserQuestionnaireController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserQuestionnaire models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserQuestionnaireSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserQuestionnaire model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $responseDataProvider = new ActiveDataProvider([
            'query' => $model->getUserResponses()->with('question', 'questionType'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'responseDataProvider' => $responseDataProvider,
        ]);
    }

    /**
     * Creates a new UserQuestionnaire model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserQuestionnaire();
        $modelCategory = new QuestionnaireCategory();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelCategory' => $modelCategory,
        ]);
    }

    /**
     * Updates an existing UserQuestionnaire model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelCategory = new QuestionnaireCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelCategory' => $modelCategory,
        ]);
    }

    /**
     * Deletes an existing UserQuestionnaire model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserQuestionnaire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserQuestionnaire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserQuestionnaire::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionQuestionnaire(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $categories = Questionnaire::questionnairesOfCategoryArr($cat_id);

                $formattedCatArr = array();
                foreach ($categories as $key => $value){
                    $formattedCatArr[] = array('id' => $key, 'name' => $value);
                }

                return ['output'=>$formattedCatArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionRateResponses($id)
    {
        $user_questionnaire = $this->findModel($id);
        ScoreCalculatorHelper::rateResponses($user_questionnaire);

        return $this->actionView($id);
    }

    public function actionCalculateScore($id)
    {
        $user_questionnaire = $this->findModel($id);
        ScoreCalculatorHelper::calculateScore($user_questionnaire);

        return $this->actionView($id);
    }
}
