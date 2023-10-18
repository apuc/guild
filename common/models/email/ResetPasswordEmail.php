<?php

namespace common\models\email;

use common\models\User;
use Yii;

class ResetPasswordEmail extends Email
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->sendTo = $user->email;
        $this->subject = 'Password reset for ' . Yii::$app->name;
        $this->mailLayout = ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text']; //+
        $this->params = ['user' => $user];//+
    }
}