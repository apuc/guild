<?php

namespace backend\modules\achievements\models;

use Yii;
use common\models\FieldsValueNew;

class Achievement extends \common\models\Achievement
{

    public $fields;

    public function behaviors()
    {
        return [
            'log' => [
                'class' => \common\behaviors\LogBehavior::class,
            ]
        ];
    }
}
