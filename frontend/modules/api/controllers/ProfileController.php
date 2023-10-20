<?php

namespace frontend\modules\api\controllers;

use common\models\UserCard;
use frontend\modules\api\services\ProfileService;
use yii\helpers\ArrayHelper;
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

    private ProfileService $profileService;

    public function __construct(
        $id,
        $module,
        ProfileService $profileService,
        $config = []
    )
    {
        $this->profileService = $profileService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param null $id
     * @return array|null
     */
    public function actionIndex($id = null): ?array
    {
        return $this->profileService->getProfile($id, \Yii::$app->request->get());
    }

    /**
     * @param $id
     * @return array|null
     * @throws ServerErrorHttpException
     */
    public function actionProfileWithReportPermission($id): ?array
    {
        return $this->profileService->getProfileWithReportPermission($id);
    }

    /**
     * @param $user_id
     * @return array
     * @throws ServerErrorHttpException
     */
    public function actionGetMainData($user_id): array
    {
        return $this->profileService->getMainData($user_id);
    }

    /**
     * @param $card_id
     * @return array
     */
    public function actionPortfolioProjects($card_id): array
    {
        return $this->profileService->getPortfolioProjects($card_id);
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
        return $this->profileService->getPositionsList();
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