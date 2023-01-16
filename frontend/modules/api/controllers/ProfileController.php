<?php

namespace frontend\modules\api\controllers;

use common\services\ProfileService;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProfileController extends ApiController
{
    public $modelClass = 'frontend\modules\api\models\UserCard';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'profiles',
    ];

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    '' => ['GET', 'HEAD', 'OPTIONS'],
                    'profile-with-report-permission' => ['post', 'patch'],
                    'get-main-data' => ['get']
                ],
            ]
        ]);
    }

    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => ProfileService::getProfile(\Yii::$app->request->get()),
        ]);
    }

    public function actionPortfolioProjects($card_id): array
    {
        return ProfileService::getPortfolioProjects($card_id);
    }
}