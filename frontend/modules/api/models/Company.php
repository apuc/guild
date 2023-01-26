<?php

namespace frontend\modules\api\models;

class Company extends \common\models\Company
{
    public function fields()
    {
        return [
            'id',
            'name',
            'description',
        ];
    }

    public function extraFields(): array
    {
        return [];
    }
}
