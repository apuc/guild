<?php

namespace frontend\modules\api\models;

class Manager extends \common\models\Manager
{
    public function fields(): array
    {
        return [
            'id',
            'user_id',
            'managerEmployees'
        ];
    }

}