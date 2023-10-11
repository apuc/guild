<?php

namespace common\services;

use common\models\Manager;
use common\models\ManagerEmployee;
use common\models\Position;
use common\models\UserCard;
use common\models\UserCardPortfolioProjects;
use frontend\modules\api\models\ProfileSearchForm;
use Yii;
use yii\web\ServerErrorHttpException;

class ProfileService
{
    public static function getPortfolioProjects($card_id)
    {
        /** @var UserCardPortfolioProjects[] $portfolioProjects */
        $portfolioProjects = UserCardPortfolioProjects::find()
            ->where(['card_id' => $card_id])
            ->all();

        $array = [];
        if (!empty($portfolioProjects)) {
            foreach ($portfolioProjects as $project) {
                array_push(
                    $array,
                    [
                        'id' => $project->id,
                        'title' => $project->title,
                        'description' => $project->description,
                        'main_stack' => $project->skill->name,
                        'additional_stack' => $project->additional_stack,
                        'link' => $project->link
                    ]
                );
            }
        }
        return $array;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public static function getMainData($user_id): array
    {
        $userCard = UserCard::findOne(['id_user' => $user_id]);
        if (empty($userCard)) {
            throw new ServerErrorHttpException('Profile not found!');
        }
        return array('fio' => $userCard->fio,
            'photo' => $userCard->photo,
            'gender' => $userCard->gender,
            'level' => $userCard->level,
            'years_of_exp' => $userCard->years_of_exp,
            'specification' => $userCard->specification,
            'position_name' => $userCard->position->name);
    }

    public static function getProfile($id, $request): ?array
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->attributes = $request;

        if ($id) {
            return $searchModel->byId();
        }
        return $searchModel->byParams();
    }

    public static function getProfileById($id): ?array
    {
        $searchModel = new ProfileSearchForm();
        $searchModel->id = $id;
        return $searchModel->byId();

    }

    /**
     * @throws ServerErrorHttpException
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
        throw new ServerErrorHttpException('There is no user with this id');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getPositionsList()
    {
        return Position::find()->all();
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