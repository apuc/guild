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
        if ($this->id === $this->searcherID) {
            return true;
        }
        return false;
    }

    private function isMyEmployee()
    {
       if (!$this->amIManager()) {
           return false;
       }

       if ($this->findEmploee()) {
           return true;
       }
       return false;
    }

    private function amIManager()
    {
        if (Manager::findOne($this->searcherID)) {
            return true;
        }
        return false;
    }

    private function findEmploee()
    {
        $exist = ManagerEmployee::find()
            ->where(['manager_id' => $this->searcherID, 'user_card_id' => $this->id])
            ->exists();

        if ($exist) {
            return true;
        }
        return false;
    }



}