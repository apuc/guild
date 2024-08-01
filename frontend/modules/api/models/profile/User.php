<?php

namespace frontend\modules\api\models\profile;

use common\classes\Debug;
use frontend\modules\api\models\project\Project;
use frontend\modules\api\services\ProfileService;
use yii\helpers\ArrayHelper;

class User extends \common\models\User
{

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'email',
            'username',
            'userCard' => function () {
                if(isset($this->userCard->id)){
                    return ProfileService::getProfileById($this->userCard->id);
                }

                return null;
            }
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [
            'projectUser' => function () {
                if ($this->projectUser){
                    return Project::find()->where(['id' => ArrayHelper::getColumn($this->projectUser, "project_id")])->all();
                }

                return null;
            },
        ];
    }

}