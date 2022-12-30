<?php

namespace frontend\modules\api\controllers;

use common\services\ProfileService;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProfileController extends ApiController
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    '' => ['get'],
                    'profile-with-report-permission' => ['post', 'patch'],
                    'get-main-data' => ['get']
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = null): ?array
    {
        return  ProfileService::getProfile($id, \Yii::$app->request->get());
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionProfileWithReportPermission($id): ?array
    {
        return ProfileService::getProfileWithReportPermission($id);
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionGetMainData($user_id): array
    {
        return ProfileService::getMainData($user_id);
    }

    public function actionPortfolioProjects($card_id): array
    {
        return ProfileService::getPortfolioProjects($card_id);
    }
}