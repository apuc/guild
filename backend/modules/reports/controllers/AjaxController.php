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

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $reports = $dataProvider->getModels();
        $reports_no_task = array_column($reports, 'attributes');
        for ($i = 0; $i<count($reports); $i++){
            $reports_no_task[$i]['today'] = array_column( $reports[$i]->task, 'attributes');
        }
        $reports = $reports_no_task;

        $month = new Month($year.'-'.$month.'-01');


        $response = Yii::$app->response;

        $response->format = Response::FORMAT_JSON;

        $response->content = json_encode(array_merge(['reports' => $reports_no_task],
            ['month'=>(array)$month]));
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
}