<?php

namespace common\services;

use common\models\UserCard;

class ManagerService
{
    public static function getManagerList()
    {
        return UserCard::find()->select(['fio','manager.id' , 'email'])
            ->joinWith('manager')->where(['NOT',['manager.user_card_id' => null]])->all();
    }

    public static function getManager($manager_id)
    {
        return UserCard::find()
            ->select(['manager.id', 'fio', 'email', 'photo', 'gender'])
            ->joinWith([
                'manager' => function ($query) { $query->select(['id']); }
            ])
            ->where(['manager.id' => $manager_id])
            ->asArray()
            ->one();
    }

    public static function getManagerEmployeesList($manager_id)
    {
        return UserCard::find()
            ->select(['user_card.id', 'user_card.fio', 'user_card.email'])
            ->joinWith('managerEmployee')
            ->where(['manager_employee.manager_id' => $manager_id])
            ->all();
    }
}