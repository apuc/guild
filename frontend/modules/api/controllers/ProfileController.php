<?php

namespace frontend\modules\api\controllers;

use common\behaviors\GsCors;
use common\classes\Debug;
use common\models\InterviewRequest;
use frontend\modules\api\models\ProfileSearchForm;
use kavalar\BotNotificationTemplateProcessor;
use kavalar\TelegramBotService;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ProfileController extends \yii\rest\Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ]
//            'corsFilter' => [
//                'class' => GsCors::class,
//                'cors' => [
//                    'Origin' => ['https://itguild.info'],
//                    //'Access-Control-Allow-Credentials' => true,
//                    'Access-Control-Allow-Headers' => [
//                        'Content-Type',
//                        'Access-Control-Allow-Headers',
//                        'Authorization',
//                        'X-Requested-With'
//                    ],
//                ]
//            ]
        ];
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

    public function actionAddToInterview()
    {
        if (\Yii::$app->request->isPost) {
            $attributes = \Yii::$app->request->post();

            $model = new InterviewRequest();
            $model->attributes = $attributes;
            $model->created_at = time();
            $model->user_id = \Yii::$app->user->id;

            if ($model->save()) {
                $token = \Yii::$app->params['telegramBotToken'];
                $chat_id = \Yii::$app->params['telegramBotChatId'];

                $templates = [
                  'interview_request'  => 
                      "Пришёл запрос на интервью.\n".
                      "Профиль: ~profile_id~\n".
                      "Телефон: ~phone~\n".
                      "Email: ~email~\n".
                      "Комментарий: ~comment~"
                ];
                $templateProcessor = new BotNotificationTemplateProcessor($templates);
                $message = $templateProcessor->renderTemplate('interview_request', $attributes);

                $bot = new TelegramBotService($token);
                $bot->sendMessageTo($chat_id, $message);
                return ['status' => 'success'];
            }

            \Yii::$app->response->statusCode = 400;
            return ['status' => 'error', 'errors' => $model->errors];
        }
    }

}
