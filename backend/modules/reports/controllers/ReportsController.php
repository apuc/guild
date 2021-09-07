<?php

namespace backend\modules\reports\controllers;

use backend\modules\card\models\UserCardSearch;
use backend\modules\reports\models\Month;
use Yii;
use common\models\Reports;
use backend\modules\reports\models\ReportsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsonResponseFormatter;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportsSearch();
        $reports = $searchModel->search([])->getModels();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user_id__fio = [];
        for ($i=0; $i<count($reports);$i++){
            $user_id__fio[$reports[$i]->user_card_id] = \common\models\Reports::getFio($reports[$i]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id__fio' => $user_id__fio,

        ]);
    }


    public function actionUser($id, $date = null)
    {
        if (!(isset($date) and preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $date))) {
            $date = date('Y-m-01');
        }
        $date = date('Y-m-01', strtotime($date));

        $searchModel = new ReportsSearch();
        $searchModel->id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $reports = $dataProvider->getModels();

        $ID = $reports[0]->user_card_id;

        $reports_no_task = array_column($reports, 'attributes');
        for ($i = 0; $i < count($reports); $i++) {
            $reports_no_task[$i]['today'] = array_column($reports[$i]->task, 'attributes');
        }
        $month = new Month($date);

        if (!Yii::$app->request->isAjax) {
            return $this->render('user', [
                'ID' => $ID,
                'reports' => $reports,
                'reports_month' => json_encode(array_merge(['reports' => $reports_no_task],
                    ['month' => (array)$month])),
                'date' => $date
            ]);
        }
    }

    public function actionGroup()
    {
        $searchModel = new UserCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->innerJoin('reports', 'user_card.id = reports.user_card_id');

        return $this->render('group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Reports model.
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
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reports model.
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
     * Deletes an existing Reports model.
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
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
