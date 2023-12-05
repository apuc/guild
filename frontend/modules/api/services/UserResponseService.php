<?php

namespace frontend\modules\api\services;

use common\classes\Debug;
use common\services\ScoreCalculatorService;
use frontend\modules\api\models\questionnaire\UserQuestionnaire;
use frontend\modules\api\models\UserResponse;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseService
{
    /**
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public static function createUserResponses($userResponsesParams, UserQuestionnaire $userQuestionnaire): array
    {
        $userResponseModels = array();
        try {
            $userResponsesParamsArray = json_decode($userResponsesParams, true);
        }
        catch (\Exception $ex) {
            throw new BadRequestHttpException('userResponses is not json');
        }

        foreach ($userResponsesParamsArray as $userResponse) {
            $model = new UserResponse();
            $model->load($userResponse, '');
            $model->user_id = $userQuestionnaire->user_id;
            $model->user_questionnaire_uuid = $userQuestionnaire->uuid;

            try {
                self::validateResponseModel($model);
            } catch (\Exception $ex) {
                throw new BadRequestHttpException($ex->getMessage());
            }


            $userResponseModels[] = $model;
        }

        foreach ($userResponseModels as $responseModel) {
            (new UserResponseService)->saveModel($responseModel);
        }

        return $userResponseModels;
    }

    /**
     * @throws BadRequestHttpException
     */
    protected  static function validateResponseModel($model)
    {
        if (!$model->validate()) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if (empty($model->user_id) or empty($model->question_id) or empty($model->user_questionnaire_uuid)) {
            throw new BadRequestHttpException(json_encode('One of t222he parameters is empty!'));
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