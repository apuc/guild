<?php

namespace frontend\modules\api\controllers;

use common\helpers\ScoreCalculatorHelper;
use common\models\UserResponse;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseController extends ApiController
{
    public $modelClass = 'common\models\UserResponse';

//    public function behaviors(): array
//    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['authenticator']['authMethods'] = [
//            HttpBearerAuth::className(),
//        ];
//
//        return $behaviors;
//    }

    public function verbs(): array
    {
        return [
            'set-response' => ['post'],
            'set-responses' => ['post'],
        ];
    }

//    public function actions()
//    {
//        $actions = parent::actions();
//        unset($actions['create']);
//        return $actions;
//    }

    /**
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionSetResponse()
    {
        $request = Yii::$app->getRequest()->getBodyParams();

        $model = new UserResponse();
        $model->load($request, '');

        $this->validateResponseModel($model);
        $this->saveModel($model);

        return $model;
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     * @throws BadRequestHttpException
     */
    public function actionSetResponses(): array
    {
        $requests = Yii::$app->getRequest()->getBodyParams();

        $responseModels = array();

        foreach ($requests['userResponses'] as $request) {
            $model = new UserResponse();
            $model->load($request, '');
            $this->validateResponseModel($model);

            array_push($responseModels, $model);
        }

        foreach ($responseModels as $responseModel) {
            $this->saveModel($responseModel);
        }

        return $responseModels;
    }

    /**
     * @throws BadRequestHttpException
     */
    protected function validateResponseModel($model)
    {
        if(!$model->validate()) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if (empty($model->user_id) or empty($model->question_id) or empty($model->user_questionnaire_uuid)) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }

    /**
     * @throws ServerErrorHttpException
     */
    protected function saveModel($model)
    {
        if ($model->save()) {
            ScoreCalculatorHelper::rateOneResponse($model);
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}
