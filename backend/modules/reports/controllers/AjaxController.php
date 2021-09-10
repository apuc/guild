<?php

namespace backend\modules\reports\controllers;

use backend\modules\reports\models\Month;
use Yii;
use backend\modules\reports\models\ReportsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{

    public function actionGetReportsForMonthByIdYearMonth($user_id, $year, $month){
        $searchModel = new ReportsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $reports_array = ArrayHelper::toArray($dataProvider->getModels(), [
            'common\models\Reports' => [
                'id',
                'created_at',
                'difficulties',
                'tomorrow',
                'user_card_id',
                'today' => function ($report) {
                    return ArrayHelper::toArray($report->task, [
                        'common\models\ReportsTask' => [
                            'hours_spent',
                            'task'
                        ],
                    ]);
                }
            ],
        ]);

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');
        $response->content = json_encode($reports_array);

        return $response;
    }
}