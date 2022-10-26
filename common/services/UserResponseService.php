<?php

namespace common\services;

use common\models\UserResponse;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseService
{
    /**
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public static function createUserResponse($userResponseParams): UserResponse
    {
        $userResponse = new UserResponse();
        $userResponse->load($userResponseParams, '');
        (new UserResponseService)->validateResponseModel($userResponse);
        (new UserResponseService)->saveModel($userResponse);
        return $userResponse;
    }

    /**
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public static function createUserResponses($userResponsesParams): array
    {
        $userResponseModels = array();
        foreach ($userResponsesParams['userResponses'] as $userResponseParams) {
            $model = new UserResponse();
            $model->load($userResponseParams, '');
            (new UserResponseService)->validateResponseModel($model);

            array_push($userResponseModels, $model);
        }

        foreach ($userResponseModels as $responseModel) {
            (new UserResponseService)->saveModel($responseModel);
        }

        return $userResponseModels;
    }

    /**
     * @throws BadRequestHttpException
     */
    protected function validateResponseModel($model)
    {
        if (!$model->validate()) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if (empty($model->user_id) or empty($model->question_id) or empty($model->user_questionnaire_uuid)) {
            throw new BadRequestHttpException(json_encode('One of the parameters is empty!'));
        }
    }

    /**
     * @throws ServerErrorHttpException
     */
    protected function saveModel($model)
    {
        if ($model->save()) {
            ScoreCalculatorService::rateOneResponse($model);
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}