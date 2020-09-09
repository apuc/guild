<?php


namespace backend\modules\balance\models;


use common\classes\Debug;
use common\models\FieldsValue;
use common\models\FieldsValueNew;
use common\models\ProjectUser;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $type
 * @property int $summ
 * @property int $dt_add
 */
class Balance extends \common\models\Balance
{
    public function behaviors()
    {
        return [
            'log' => [
                'class' => \common\behaviors\LogBehavior::class,
            ]
        ];
    }
}