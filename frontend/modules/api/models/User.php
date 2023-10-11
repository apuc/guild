<?php

namespace frontend\modules\api\models;

use backend\modules\card\models\UserCardSearch;
use common\services\ProfileService;

class User extends \common\models\User
{

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'email',
            'username',
            'userCard' => function () {
                $userCard = new UserCardSearch();
                return ProfileService::getProfileById($this->userCard->id);
            }
        ];
    }

}