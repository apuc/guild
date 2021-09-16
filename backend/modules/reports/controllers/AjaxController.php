<?php

namespace backend\modules\reports\controllers;


use Yii;
use backend\modules\reports\models\ReportsSearch;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{

    public function actionGetReportsForDayByDate($date, $user_id = null)
    {
        $searchModel = new ReportsSearch();
        $params = ['ReportsSearch' => ['created_at' => $date]];
        $view = '_gridViewAllUsers';
        if ($user_id){
            $params['user_id'] = $user_id;
            $view = '_gridViewOneUser';
        }
        $dataProvider = $searchModel->search($params);
        return $this->render($view, [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetReportsForMonthByIdYearMonth($year, $month, $user_id=null)
    {
        $searchModel = new ReportsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $reports_array = array_column($dataProvider->getModels(), 'created_at');

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');
        $response->content = json_encode($reports_array);

        return $response;
    }
}