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

    public function actionGetReportsForMonthByIdYearMonth($user_id, $year, $month){
        $searchModel = new ReportsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $reports = $dataProvider->getModels();
        $reports_array = array_column($reports, 'attributes');
        foreach ($reports as $i => $report){
            $reports_array[$i]['today'] = array_column($report->task, 'attributes');
        }

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');
        $response->content = json_encode(array_merge(
                ['reports' => $reports_array],
                ['month' => (array)new Month($year.'-'.$month.'-01')])
        );

        return $response;
    }
}