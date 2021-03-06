<?php

namespace backend\modules\settings\models;

use common\models\UseStatus;

class Status extends \common\models\Status
{
    public function afterSave($insert, $changedAttributes)
    {
        UseStatus::deleteAll(['status_id' => $this->id]);
        foreach ($this->use as $item) {
            $useStatus = new UseStatus();
            $useStatus->status_id = $this->id;
            $useStatus->use = $item;

            $useStatus->save();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}