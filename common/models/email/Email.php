<?php

namespace common\models\email;

class Email
{
    /**
     * @var string
     */
    public string $sendTo;
    /**
     * @var string
     */
    public string $subject;
    /**
     * @var array
     */
    public array $mailLayout;
    /**
     * @var array
     */
    public array $params;
}