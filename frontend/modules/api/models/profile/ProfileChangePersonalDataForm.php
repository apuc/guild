<?php

namespace frontend\modules\api\models\profile;

use yii\base\Model;

class ProfileChangePersonalDataForm extends Model
{
    /**
     * @var string
     */
    public $newUsername;
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['newUsername'], 'string', 'max' => 255],
            [['newUsername'], 'required'],
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