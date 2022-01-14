<?php

namespace common\services;

use common\models\Manager;
use common\models\ManagerEmployee;

class ProfileService
{
    private $searcherID;
    private $id;

    public function __construct($searcherID, $id)
    {
        $this->searcherID = $searcherID;
        $this->id = $id;
    }

    public function checkReportePermission()
    {
        if ($this->isMyProfile() or $this->isMyEmployee()) {
            return true;
        }
        return false;
    }

    private function isMyProfile()
    {
        if ($this->id == $this->searcherID) {
            return true;
        }
        return false;
    }

    private function isMyEmployee()
    {
       if (!$this->amIManager()) {
           return false;
       }

       if ($this->isMyEmploee()) {
           return true;
       }
       return false;
    }

    private function amIManager()
    {
        if (Manager::find()->where(['user_card_id' => $this->searcherID])->exists()) {
            return true;
        }
        return false;
    }

    private function isMyEmploee()
    {
        $manager = Manager::find()->where(['user_card_id' => $this->searcherID])->one();
        $exist = ManagerEmployee::find()
            ->where(['manager_id' => $manager->id, 'user_card_id' => $this->id])
            ->exists();

        if ($exist) {
            return true;
        }
        return false;
    }



}