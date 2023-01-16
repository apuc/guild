<?php

namespace frontend\modules\api\models;

use common\services\ProfileService;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class UserCard extends \common\models\UserCard implements Linkable
{
    public function fields(): array
    {
        return [
            'fio',
            'photo',
            'gender',
            'position_id',
            'city',
            'vc_text',
            'level',
            'vc_text_short',
            'years_of_exp',
            'specification',
            'resume_text',
            'at_project'
        ];
    }

    public function extraFields(): array
    {
        return [
            'permission_view_reports' => function () {
                return ProfileService::checkPermissionToViewReports($this->id);
            },
            'skills' => function() {
                return $this->getSkills()->all();
            },
            'achievements' => function() {
                return $this->getAchieve()->all();
            }
        ];
    }

    public function getLinks(): array
    {
        return [
            Link::REL_SELF => Url::to(['index', 'card_id' => $this->id], true),
        ];
    }
}