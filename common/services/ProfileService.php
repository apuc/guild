<?php

namespace common\services;

use common\models\Manager;
use common\models\ManagerEmployee;
use common\models\UserCard;
use frontend\modules\api\models\ProfileSearchForm;
use frontend\modules\api\models\UserCardPortfolioProjects;
use Yii;
use yii\db\ActiveQuery;

class ProfileService
{
    public static function getProfile( $request): ActiveQuery
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = $request;

        if ($searchModel->card_id) {
            return $searchModel->byId();
        }
        return $searchModel->byParams();
    }

    public static function getPortfolioProjects($card_id): array
    {
        /** @var UserCardPortfolioProjects[] $portfolioProjects */
        return UserCardPortfolioProjects::find()
            ->where(['card_id' => $card_id])
            ->all();
    }

    public static function checkPermissionToViewReports($user_card_id): bool //&$profile,
    {
        $searcherCardID = self::getSearcherCardID(Yii::$app->user->getId());
        if (self::checkReportPermission($user_card_id, $searcherCardID)) {
            return true;
        }
        return false;
    }

    private static function getSearcherCardID($user_id): int
    {
        return UserCard::findOne(['id_user' => $user_id])->id;
    }

    private static function checkReportPermission($user_card_id, $searcherCardID): bool
    {
        if (self::isMyProfile($user_card_id, $searcherCardID)
            or self::isMyEmployee($user_card_id, $searcherCardID)) {
            return true;
        }
        return false;
    }

    private static function isMyProfile($user_card_id, $searcherCardID): bool
    {
        if ($user_card_id == $searcherCardID) {
            return true;
        }
        return false;
    }

    private static function isMyEmployee($user_card_id, $searcherCardID): bool
    {
        if (!self::amIManager($searcherCardID)) {
            return false;
        }

        if (self::isMyEmployer($user_card_id, $searcherCardID)) {
            return true;
        }
        return false;
    }

    private static function amIManager($searcherCardID): bool
    {
        if (Manager::find()->where(['user_card_id' => $searcherCardID])->exists()) {
            return true;
        }
        return false;
    }

    private static function isMyEmployer($user_card_id, $searcherCardID): bool
    {
        $manager = Manager::find()->where(['user_card_id' => $searcherCardID])->one();
        $exist = ManagerEmployee::find()
            ->where(['manager_id' => $manager->id, 'user_card_id' => $user_card_id])
            ->exists();

        if ($exist) {
            return true;
        }
        return false;
    }
}