<?php

namespace backend\modules\holiday\models;

class Holiday extends \common\models\Holiday
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