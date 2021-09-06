<?php

namespace backend\modules\reports\controllers;

use backend\modules\reports\models\Month;
use common\classes\Debug;
use Yii;
use backend\modules\reports\models\ReportsSearch;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{
    public function actionGetReportsForMonthByIdYearMonth($id, $year=null, $month=null){
        if (!($year and $month)){
            $searchModel->month = date('m');
            $searchModel->year = date('Y');
            Debug::prn('Неверный год или месяц');
        }

        $searchModel = new ReportsSearch();
        $searchModel->id = $id;
        $searchModel->month = $month;
        $searchModel->year = $year;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $reports = ['reports'=>array_column($dataProvider->getModels(), 'attributes')];
        $month = new Month($year.'-'.$month.'-01');


        $response = Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        $response->content = json_encode(array_merge($reports,
            ['month'=>(array)$month]));
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
}