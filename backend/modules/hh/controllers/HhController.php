<?php

namespace backend\modules\hh\controllers;

use common\classes\Debug;
use common\hhapi\core\service\HHService;
use common\models\HhJob;
use Yii;
use backend\modules\hh\models\Hh;
use backend\modules\hh\models\HhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HhController implements the CRUD actions for Hh model.
 */
class HhController extends Controller
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
     * Lists all Hh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HhSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hh model.
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
     * Creates a new Hh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Hh();

        if ($model->load(Yii::$app->request->post())) {
            $hhId = explode('/', $model->url);
            $model->hh_id = $hhId[4];
            $model->dt_add = time();
            //$jobs = HHService::run()->company($model->hh_id)->getJobs();
            $company = HHService::run()->company($model->hh_id)->get();
            if (isset($company->name)) {
                $model->title = $company->name;
                $model->photo = $company->logo_urls->{240};
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Hh model.
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
     * Deletes an existing Hh model.
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

    public function actionGetJobs($id)
    {
        $model = \common\models\Hh::findOne($id);
        $jobs = HHService::run()->company($model->hh_id)->getJobs();
        $count = 0;
        foreach ((array)$jobs as $job) {
            if(HhJob::createFromHH($job)){
                $count++;
            }
        }
        Yii::$app->session->setFlash('success', "Получено $count новых вакансий");
        return $this->redirect(['/hh/hh']);
    }

    /**
     * Finds the Hh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
