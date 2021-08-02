<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\models\Reports;
use frontend\modules\api\models\ReportSearchForm;
use JsonException;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReportsController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => GsCors::class,
                'cors' => [
                    'Origin' => ['*'],
                    //'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Headers' => [
                        'Content-Type',
                        'Access-Control-Allow-Headers',
                        'Authorization',
                        'X-Requested-With'
                    ],
                ]
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
        ];
    }

    public function actionIndex(): array
    {
        $reportsModel = new ReportSearchForm();

        $params = Yii::$app->request->get();
        $reportsModel->attributes = $params;

        if(!$reportsModel->validate()){
            return $reportsModel->errors;
        }
        return $reportsModel->byParams();
    }

    public function actionCreate()
    {
        $reportsModel = new Reports();

        $params = Yii::$app->request->get();
        $reportsModel->attributes = $params;

        if(!$reportsModel->validate()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $reportsModel->save();

        return $reportsModel->toArray();
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $report = Reports::findOne($id);

        if(null === $report) {
            throw new NotFoundHttpException('Report not found');
        }

        if(false === ($report->delete())) {
            throw new JsonException('Report not deleted');
        }

        return true;
    }

    public function actionUpdate(): array
    {
        $params = Yii::$app->request->get();

        $reportsModel = Reports::findone($params['id']);
        if(!isset($reportsModel)) {
            throw new NotFoundHttpException('report not found');
        }

        if(isset($params['user_card_id'])) {
            throw new JsonException('constraint by user_card_id');
        }

        $reportsModel->attributes = $params;

        if(!$reportsModel->validate()){
            throw new BadRequestHttpException(json_encode($reportsModel->errors));
        }

        $reportsModel->save();

        return $reportsModel->toArray();
    }

}
