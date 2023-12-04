<?php

namespace common\services;

use common\models\email\Email;
use Yii;

class EmailService
{
    private array $sendFrom;

    public function __construct()
    {
        $this->sendFrom = [Yii::$app->params['senderEmail'] => Yii::$app->name . ' robot'];

    }

    /**
     * @param Email $email
     * @return bool
     */
    public function sendEmail(Email $email): bool
    {
        return Yii::$app->mailer->compose(
            $email->mailLayout,
            $email->params,
        )
            ->setFrom($this->sendFrom)
            ->setTo($email->sendTo)
            ->setSubject($email->subject)
            ->send();
    }
}