<?php

namespace backend\modules\questionnaire\controllers;

use backend\modules\questionnaire\models\Questionnaire;
use backend\modules\questionnaire\models\UserQuestionnaire;
use Yii;
use backend\modules\questionnaire\models\UserResponse;
use backend\modules\questionnaire\models\UserResponseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserResponseController implements the CRUD actions for UserResponse model.
 */
class UserResponseController extends Controller
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
     * Lists all UserResponse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $questionnaire = new Questionnaire();
        $model = new UserResponse();

        $searchModel = new UserResponseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            'model' => $model,
            'questionnaire' => $questionnaire
        ]);
    }

    /**
     * Displays a single UserResponse model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserResponse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserResponse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserResponse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id, $user_questionnaire_id = null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($user_questionnaire_id !== null)
            {
                return $this->redirect(['user-questionnaire/view', 'id' => $user_questionnaire_id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserResponse model.
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
     * Finds the UserResponse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserResponse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserResponse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionQuestionnaire()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $user_id = $parents[0];

                $questionnairesArr = UserQuestionnaire::getQuestionnaireByUser($user_id);

                return ['output'=>$questionnairesArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionTest()
    {
        return $this->render('update', [
            'model' => new UserQuestionnaire(),
        ]);
    }
}
