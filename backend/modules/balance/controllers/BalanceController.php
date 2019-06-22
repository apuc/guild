<?php

namespace backend\modules\balance\controllers;

use backend\modules\balance\models\Balance;
use backend\modules\balance\models\BalanceSearch;
use common\classes\Debug;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;

class BalanceController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BalanceSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view',[
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Balance();

        if ($model->load(Yii::$app->request->post())) {
            $model->dt_add = strtotime($model->dt_add);
            $model->save();
//            Debug::dd($model);

            Yii::$app->session->addFlash('success', 'Баланса добавлен');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update',[
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