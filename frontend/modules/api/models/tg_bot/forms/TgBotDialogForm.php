<?php

namespace frontend\modules\api\models\tg_bot\forms;
use yii\base\Model;

class TgBotDialogForm extends Model
{

    public int|null $user_id = null;
    public int $dialog_id;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['dialog_id', 'user_id'], 'integer'],
            [['dialog_id'], 'required'],
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
