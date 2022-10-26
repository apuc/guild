<?php

namespace frontend\modules\api\controllers;

use common\models\UserResponse;
use common\services\UserResponseService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseController extends ApiController
{
    public function verbs(): array
    {
        return [
            'set-response' => ['post'],
            'set-responses' => ['post'],
        ];
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException|BadRequestHttpException
     */
    public function actionSetResponse(): UserResponse
    {
        $userResponseModel = UserResponseService::createUserResponse(Yii::$app->getRequest()->getBodyParams());
        if ($userResponseModel->errors) {
            throw new ServerErrorHttpException(json_encode($userResponseModel->errors));
        }
        return $userResponseModel;
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException|BadRequestHttpException
     */
    public function actionSetResponses(): array
    {
        $userResponseModels = UserResponseService::createUserResponses(Yii::$app->getRequest()->getBodyParams());
        foreach ($userResponseModels as $model) {
            if ($model->errors) {
                throw new ServerErrorHttpException(json_encode($model->errors));
            }
        }
        return $userResponseModels;
    }
}
