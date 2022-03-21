<?php

namespace frontend\modules\api\controllers;

use common\models\InterviewRequest;
use common\services\InterviewRequestService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;


class InterviewRequestController extends ApiController
{
    public function verbs(): array
    {
        return [
            'create-interview-request' => ['post']
        ];
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionCreateInterviewRequest(): InterviewRequest
    {
        $InterviewRequestModel = InterviewRequestService::createInterviewRequest(Yii::$app->getRequest()->getBodyParams());
        if ($InterviewRequestModel->errors) {
            throw new ServerErrorHttpException(json_encode($InterviewRequestModel->errors));
        }
        return $InterviewRequestModel;
    }
}