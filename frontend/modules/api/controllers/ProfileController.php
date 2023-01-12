<?php

namespace frontend\modules\api\controllers;

use common\services\ProfileService;
use yii\helpers\ArrayHelper;
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
                    'index' => ['get'],
                    'profile-with-report-permission' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($card_id = null)
    {
        $profiles =  ProfileService::getProfile($card_id, \Yii::$app->request->get());
        if(empty($profiles)) {
            throw new NotFoundHttpException('Profiles not found');
        }
        return $profiles;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionProfileWithReportPermission($card_id): ?array
    {
        return ProfileService::getProfileWithReportPermission($card_id);
    }

    public function actionPortfolioProjects($card_id): array
    {
        return ProfileService::getPortfolioProjects($card_id);
    }
}