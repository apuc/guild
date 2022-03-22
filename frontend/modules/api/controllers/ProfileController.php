<?php

namespace frontend\modules\api\controllers;

use common\services\ProfileService;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class ProfileController extends ApiController
{
    public function verbs(): array
    {
        return [
            '' => ['get'],
            'profile-with-report-permission' => ['post', 'patch']
        ];
    }

    public function actionIndex($id = null): ?array
    {
        return ProfileService::getProfile($id, \Yii::$app->request->get());
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
}