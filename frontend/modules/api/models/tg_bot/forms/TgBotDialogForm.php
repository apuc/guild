<?php

namespace frontend\modules\api\models\tg_bot\forms;
use yii\base\Model;

class TgBotDialogForm extends Model
{

    public $userId;
    public $dialogId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['dialogId', 'userId'], 'integer'],
            [['dialogId', 'userId'], 'required'],
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
