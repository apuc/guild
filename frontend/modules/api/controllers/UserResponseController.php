<?php

namespace frontend\modules\api\controllers;

use common\models\UserResponse;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class UserResponseController extends ActiveController
{
    public $modelClass = 'common\models\UserResponse';

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function verbs(): array
    {
        return [
            'set-response' => ['post'],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionSetResponse(): UserResponse
    {
        $model = new UserResponse();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if(!$model->validate()){
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if (empty($model->user_id) or empty($model->question_id) or empty($model->user_questionnaire_uuid)) {
            throw new BadRequestHttpException(json_encode($model->errors));
        }

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}
