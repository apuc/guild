<?php

namespace frontend\modules\api\models\tg_bot\forms;
use yii\base\Model;

class TgBotDialogIdForm extends Model
{
    public $dialogId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['dialogId'], 'integer'],
            [['dialogId'], 'required'],
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
