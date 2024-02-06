<?php

namespace common\models\email;

use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use Yii;

class AddToProjectEmail extends Email
{

    /**
     * @param User $user
     * @param Project $project
     */
    public function __construct(User $user, Project $project)
    {
        $this->sendTo = $user->email;
        $this->subject = 'Вас добавили в проект';
        $this->mailLayout = ['html' => 'addToProjectByEmail-html', 'text' => 'addToProjectByEmail-text'];
        $this->params = ['user' => $user, 'project' => $project];
    }

}