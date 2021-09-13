<?php

namespace backend\modules\calendar\controllers;

use backend\modules\card\models\UserCardSearch;
use Yii;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{

    public function actionGetBirthdayDate($date)
    {
        $searchModel = new UserCardSearch();
        $dataProvider = $searchModel->search(['date' => $date]);

        return $this->render('_gridView', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionGetBirthdayDatesByMonth($month )
    {
        $searchModel = new UserCardSearch();
        $models = $searchModel->search(Yii::$app->request->queryParams)->getModels();
        $models_array = array_map(function ($date){return date('Y').substr($date, 4,6);},
            array_column($models, 'dob')
        );


        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');
        $response->content = json_encode(
            $models_array
        );
        return $response;
    }
}?>
