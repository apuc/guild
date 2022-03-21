<?php

namespace frontend\modules\api\controllers;

use common\services\ProfileService;
use yii\web\BadRequestHttpException;

class ProfileController extends ApiController
{
    public function verbs(): array
    {
        return [
            '' => ['get'],
            'profile-with-report-permission' => ['post', 'patch']
        ];
    }

    public function actionIndex($id = null)
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
}