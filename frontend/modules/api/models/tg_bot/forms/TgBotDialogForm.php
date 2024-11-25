<?php

namespace frontend\modules\api\models\tg_bot\forms;
use yii\base\Model;

/**
 * @property integer $user_id
 * @property integer $dialog_id
 * @property integer $status
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $key_words
 */
class TgBotDialogForm extends Model
{

    public int|null $user_id = null;
    public int $dialog_id;
    public int $status = 1;
    public string $username = "";
    public string $first_name = "";
    public string $last_name = "";
    public string $key_words = "";

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['dialog_id', 'user_id', 'status'], 'integer'],
            [['username', 'first_name', 'last_name', 'key_words'], 'string'],
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
