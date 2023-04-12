<?php

namespace frontend\modules\api\controllers;

use common\models\User;
use common\models\UserCard;
use common\services\ProfileService;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProfileController extends ApiController
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    '' => ['GET', 'HEAD', 'OPTIONS'],
                    'profile-with-report-permission' => ['post', 'patch'],
                    'get-main-data' => ['get'],
                    'positions-list' => ['get'],
                    'level-list' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = null): ?array
    {
        return ProfileService::getProfile($id, \Yii::$app->request->get());
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionProfileWithReportPermission($id): ?array
    {
        return ProfileService::getProfileWithReportPermission($id);
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function actionGetMainData($user_id): array
    {
        return ProfileService::getMainData($user_id);
    }

    public function actionPortfolioProjects($card_id): array
    {
        return ProfileService::getPortfolioProjects($card_id);
    }

    /**
     *
     * @OA\Get(path="/profile/positions-list",
     *   summary="Список позиций",
     *   description="Получить список всех возможных позиций",
     *   tags={"Profile"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив позиций",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(ref="#/components/schemas/PositionsExample"),
     *     ),
     *
     *   ),
     * )
     *
     * @return array
     */
    public function actionPositionsList(): array
    {
        return ProfileService::getPositionsList();
    }

    /**
     *
     * @OA\Get(path="/profile/level-list",
     *   summary="Список уровней навыков",
     *   description="Получить список всех возможных уровней навыков",
     *   tags={"Profile"},
     *   security={
     *     {"bearerAuth": {}}
     *   },
     *   @OA\Response(
     *     response=200,
     *     description="Возвращает массив позиций",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *
     *   ),
     * )
     *
     * @return array
     */
    public function actionLevelList(): array
    {
        return UserCard::getLevelList();
    }
}