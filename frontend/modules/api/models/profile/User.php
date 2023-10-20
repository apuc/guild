<?php

namespace frontend\modules\api\models\profile;

use frontend\modules\api\services\ProfileService;

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
                if(isset($this->userCard->id)){
                    return ProfileService::getProfileById($this->userCard->id);
                }

                return null;
            }
        ];
    }

}