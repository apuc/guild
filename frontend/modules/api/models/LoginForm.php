<?php

namespace frontend\modules\api\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;

    Const EXPIRE_TIME = 604800; // token expiration time, valid for 7 days

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
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
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            if ($this->getUser()) {
                $access_token = $this->_user->generateAccessToken();
                $this->_user->access_token_expired_at = date('Y-m-d', time() + static::EXPIRE_TIME);
                $this->_user->save();
                Yii::$app->user->login($this->_user, static::EXPIRE_TIME);
                return $access_token;
            }
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
