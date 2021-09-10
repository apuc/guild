<?php

namespace backend\modules\calendar\controllers;

use backend\modules\card\models\UserCardSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{
    public function actionGetBirthdayByMonth($month )
    {
        $searchModel = new UserCardSearch();
        $models = $searchModel->search(Yii::$app->request->queryParams)->getModels();
        $models_array = ArrayHelper::toArray($models, [
            'backend\modules\card\models\UserCard' => [
                'id',
                'dob',
                'fio'
            ],
        ]);

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->getHeaders()->set('Content-Type', 'application/json; charset=utf-8');
        $response->content = json_encode(
            $models_array
        );
        return $response;
    }
}?>
