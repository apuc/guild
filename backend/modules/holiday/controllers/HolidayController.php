<?php

namespace backend\modules\holiday\controllers;

use backend\modules\holiday\models\Holiday;
use backend\modules\holiday\models\HolidaySearch;
use common\classes\Debug;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HolidayController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new HolidaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $changeDataProvider = new ActiveDataProvider([
            'query' => \common\models\ChangeHistory::find()->where(['type_id' => $this->findModel($id)->id]),
            'pagination' => [
                'pageSize' => 200,
            ]
        ]);

        return $this->render('view', [
            'model' => $model,
            'changeDataProvider' => $changeDataProvider,
            ]);
    }

    public function actionCreate()
    {
        $model = new Holiday();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->dt_start = strtotime($model->dt_start);
            $model->dt_end = strtotime($model->dt_end);
            $model->save();

            Yii::$app->session->addFlash('success', 'Отпуск добавлен');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_start = strtotime($model->dt_start);
            $model->dt_end = strtotime($model->dt_end);
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Holiday::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}