<?php

namespace frontend\modules\api\models\profile;
use yii\base\Model;

class ProfileChangePasswordForm extends Model
{

    public $password;
    public $newPassword;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'newPassword'], 'string'],
            [['password', 'newPassword'], 'required'],
        ];
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }
}
