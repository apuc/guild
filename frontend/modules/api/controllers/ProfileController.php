<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\classes\Debug;
use common\models\InterviewRequest;
use common\models\User;
use common\services\ProfileService;
use frontend\modules\api\models\ProfileSearchForm;
use kavalar\BotNotificationTemplateProcessor;
use kavalar\TelegramBotService;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ProfileController extends ApiController
{

    public function behaviors()
    {
        $parent = parent::behaviors();
        $b = [
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
        ];

        return array_merge($parent, $b);
    }

    public function actionIndex($id = null)
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = \Yii::$app->request->get();

        if ($id) {
            return $searchModel->byId();
        }

        return $searchModel->byParams();
    }

    public function actionProfileWithReportPermission($id, $searcherID)
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = \Yii::$app->request->get();

        if ($id && $searcherID) {
            $profile = $searchModel->byId();

            $profileService = new ProfileService($searcherID, $id);
            if($profileService->checkReportePermission()) {
                $profile += ['report_permission' => '1'];
            }
            else {
                $profile += ['report_permission' => '0'];
            }
            return $profile;
        }

        throw new BadRequestHttpException(json_encode('Missing required parameter'));
    }

    public function actionAddToInterview()
    {
        if (\Yii::$app->request->isPost) {
            $attributes = \Yii::$app->request->post();

            $model = new InterviewRequest();
            $model->attributes = $attributes;
            $model->created_at = time();
            $model->user_id = \Yii::$app->user->id;
            if ($model->save()) {
                \Yii::$app->telegram_bot->sendRenderedMessage('interview_request', $attributes);
                return ['status' => 'success'];
            }

            \Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'errors' => $model->errors];
        }
    }

    public function actionMe()
    {
        if(isset(\Yii::$app->user->id)){
            $user = User::find()->with('userCard')->where(['id' => \Yii::$app->user->id])->one();
        }

        \Yii::$app->response->statusCode = 401;
        return ['status' => 'error', 'errors' => 'No authorized'];
    }

}
