<?php

namespace frontend\modules\api\models\tg_bot\forms;
use DateTime;
use frontend\modules\api\models\profile\User;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use yii\base\Model;

class UserTgBotLoginForm extends Model
{
    public $token;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['token'], 'string'],
            [['token'], 'required'],
            ['token', 'validateToken'],
        ];
    }

    /**
     * @throws \Exception
     */
    public function validateToken()
    {
        $model = UserTgBotToken::findOne(['token' => $this->token]);

        if (!empty($model)) {

            $currentTime = new DateTime();

            if ($currentTime > new DateTime($model->expired_at)) {
                $this->addError('token', 'Токен не действителен!');
            }
        } else {
            $this->addError('token', 'Пользователь с соответствующим токеном не найден!');
        }
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }

    public function getUser()
    {
        return User::findOne($this->userId);
    }
}
