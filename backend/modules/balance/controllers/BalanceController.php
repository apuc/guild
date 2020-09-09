<?php

namespace backend\modules\balance\controllers;

use backend\modules\balance\models\Balance;
use backend\modules\balance\models\BalanceSearch;
use common\classes\Debug;
use common\models\FieldsValue;
use common\models\FieldsValueNew;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;

class BalanceController extends Controller
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
        $searchModel = new BalanceSearch();
        if(\Yii::$app->request->get('month'))
        {
            $searchModel->dt_from =  date('Y-m-01');
            $searchModel->dt_to =  date('Y-m-t');
        }
        if(\Yii::$app->request->get('previous_month'))
        {
            $searchModel->dt_from =  date('Y-m-d', strtotime('first day of previous month'));
            $searchModel->dt_to =  date('Y-m-d', strtotime('last day of previous month'));
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $summ_info = $searchModel->getSummInfo();

        return $this->render('index',compact('dataProvider', 'searchModel', 'summ_info'));
    }

    public function actionView($id)
    {
        $dataProviderF = new ActiveDataProvider([
            'query' => FieldsValueNew::find()
                ->where(['item_id' => $id, 'item_type' => FieldsValueNew::TYPE_BALANCE])
                ->orderBy('order'),
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        $changeDataProvider = new ActiveDataProvider([
            'query' => \common\models\ChangeHistory::find()->where(['type_id' => $this->findModel($id)->id]),
            'pagination' => [
                'pageSize' => 200,
            ]
        ]);

        return $this->render('view',[
            'model' => $this->findModel($id),
            'dataProviderF' => $dataProviderF,
            'changeDataProvider' => $changeDataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Balance();

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_add = strtotime($model->dt_add);
            $model->save();

            Yii::$app->session->addFlash('success', 'Баланса добавлен');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_add = strtotime($model->dt_add);
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
        if (($model = Balance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}