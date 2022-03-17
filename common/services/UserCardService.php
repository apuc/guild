<?php

namespace common\services;

use common\models\UserCard;
use yii\web\ServerErrorHttpException;

class UserCardService
{
    /**
     * @throws ServerErrorHttpException
     */
    public static function getUserCard($user_id): array
    {
        $userCard = UserCard::findOne(['id_user' => $user_id]);
        if (empty($userCard)) {
            throw new ServerErrorHttpException(json_encode($userCard->errors));
        }
        return array('fio' => $userCard->fio,
                    'photo' => $userCard->photo,
                    'gender' => $userCard->gender,
                    'level' => $userCard->level,
                    'years_of_exp' => $userCard->years_of_exp,
                    'specification' => $userCard->specification,
                    'position_name' => $userCard->position->name);
    }
}