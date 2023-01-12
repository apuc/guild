<?php

namespace frontend\modules\api\models;

class UserCardPortfolioProjects extends \common\models\UserCardPortfolioProjects
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'main_stack',
            'additional_stack',
            'link'
        ];
    }

    public function extraFields()
    {

    }
}