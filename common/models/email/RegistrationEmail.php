<?php

namespace common\models\email;

use common\models\User;
use Yii;

class RegistrationEmail extends Email
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->sendTo = $user->email;
        $this->subject = 'Регистрация в ' . Yii::$app->name;
        $this->mailLayout = ['html' => 'signup-html', 'text' => 'signup-text'];
        $this->params = ['user' => $user];
    }
}