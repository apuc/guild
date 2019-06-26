<?php

namespace backend\modules\settings\models;

use common\classes\Debug;
use common\models\UseField;

class AdditionalFields extends \common\models\AdditionalFields
{
    public function afterSave($insert, $changedAttributes)
    {
        UseField::deleteAll(['field_id' => $this->id]);

        foreach ($this->use as $item) {
            $useField = new UseField();
            $useField->field_id = $this->id;
            $useField->use = $item;

            $useField->save();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}