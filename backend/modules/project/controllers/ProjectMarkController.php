<?php

namespace backend\modules\project\controllers;

use backend\modules\project\models\ProjectMark;
use backend\modules\project\models\ProjectMarkSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProjectMarkController implements the CRUD actions for ProjectMark model.
 */
class ProjectMarkController extends Controller
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
     * Lists all ProjectMark models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectMarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectMark model.
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
     * Creates a new ProjectMark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $marks = \Yii::$app->request->post('ProjectMark');

        if (!empty($marks)) {
            $mark_id_arr = ArrayHelper::getValue($marks, 'mark_id');
            $project_id = $marks['project_id'];

            foreach ($mark_id_arr as $mark_id) {
                $emtModel = new ProjectMark();
                $emtModel->project_id = $project_id;
                $emtModel->mark_id = $mark_id;

                if (!$emtModel->save()) {
                    return $this->render('create', [
                        'model' => $emtModel,
                    ]);
                }
            }
            return $this->redirect(['index']);
        }

        $model = new ProjectMark();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProjectMark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectMark model.
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
     * Finds the ProjectMark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectMark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectMark::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUsersNotOnProject(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $project_id = $parents[0];
                $categories = ProjectMark::getMarkNotAtProject($project_id);

                $formattedCatArr = array();
                foreach ($categories as $key => $value){
                    $formattedCatArr[] = array('id' => $key, 'name' => $value);
                }

                return ['output'=>$formattedCatArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
}
