<?php

namespace frontend\modules\api\models;

use common\classes\Debug;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    const EXPIRE_TIME = 604800; // token expiration time, valid for 7 days

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect e-mail or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            if ($this->getUser()) {
                $access_token = $this->getAccessToken();
                $this->_user->access_token_expired_at = date('Y-m-d', time() + static::EXPIRE_TIME);
                $this->_user->save();
                Yii::$app->user->login($this->_user, static::EXPIRE_TIME);
                return $access_token;
            }
        }
        return false;
    }

    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    protected function getAccessToken()
    {
        if ($this->_user !== null) {
            if ($this->_user->tokenIsExpire()){
                return $this->_user->generateAccessToken();
            }

            return $this->_user->access_token;
        }

        return false;
    }
}
