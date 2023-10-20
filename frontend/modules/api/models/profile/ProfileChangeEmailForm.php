<?php

namespace frontend\modules\api\models\profile;
use yii\base\Model;

class ProfileChangeEmailForm extends Model
{

    public $newEmail;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['newEmail'], 'string'],
            [['newEmail'], 'required'],
            [['newEmail'], 'email'],
            ['newEmail', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class],
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
