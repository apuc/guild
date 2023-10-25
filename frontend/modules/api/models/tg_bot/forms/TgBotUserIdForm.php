<?php

namespace frontend\modules\api\models\tg_bot\forms;
use yii\base\Model;

class TgBotUserIdForm extends Model
{
    public $userId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['userId'], 'required'],
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
