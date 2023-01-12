<?php

namespace frontend\modules\api\models;

class UserCard extends \common\models\UserCard
{
    public function fields()
    {
        return [
            'fio',
            'photo',
            'gender',
            'status',
            'position_id',
            'city',
            'vc_text',
            'level',
            'vc_text_short',
            'years_of_exp',
            'specification',
            'resume_text',
            'at_project',
        ];
    }

    public function extraFields()
    {
        return [
            'skills' => function() {
                return $this->getSkills()->all();
            },
            'achievements' => function() {
                return $this->getAchieve()->all();
            }
        ];
    }
}