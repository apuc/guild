<?php

namespace frontend\modules\api\models\tg_bot;

use frontend\modules\api\models\profile\User;
use yii\db\ActiveQuery;

class UserTgBotDialog extends \common\models\UserTgBotDialog
{
    public function fields(): array
    {
        return [
            'user_id',
            'dialog_id',
        ];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}