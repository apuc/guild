<?php

namespace frontend\modules\api\controllers;

use common\services\UserCardService;
use yii\web\ServerErrorHttpException;

class UserCardController extends ApiController
{
    public function verbs(): array
    {
        return [
            'get-user-card' => ['get'],
        ];
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionGetUserCard($user_id): array
    {
        return UserCardService::getUserCard($user_id);
    }
}