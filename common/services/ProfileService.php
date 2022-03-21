<?php

namespace common\services;

use common\models\Manager;
use common\models\ManagerEmployee;
use common\models\UserCard;
use frontend\modules\api\models\ProfileSearchForm;
use Yii;
use yii\web\BadRequestHttpException;

class ProfileService
{
    /**
     * @throws BadRequestHttpException
     */
    public static function getProfile($id, $request): ?array
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = $request;

        if ($id) {
            return $searchModel->byId();
        }
        return $searchModel->byParams();
    }

    /**
     * @throws BadRequestHttpException
     */
    public static function getProfileWithReportPermission($user_card_id): ?array
    {
        if (UserCard::find()->where(['id' => $user_card_id])->exists()) {

            $searchModel = new ProfileSearchForm();
            $searchModel->id = $user_card_id;
            $profile = $searchModel->byId();

            self::addPermission($profile, $user_card_id);
            return $profile;
        }
        throw new BadRequestHttpException(json_encode('There is no user with this id'));
    }

    private static function addPermission(&$profile, $user_card_id)
    {
        $searcherCardID = self::getSearcherCardID(Yii::$app->user->getId());
        if (self::checkReportPermission($user_card_id, $searcherCardID)) {
            $profile += ['report_permission' => '1'];
        } else {
            $profile += ['report_permission' => '0'];
        }
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