<?php

namespace frontend\modules\api\services;

use common\models\UserTgBotDialog;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use yii\data\ActiveDataProvider;

class UserTgBotService
{

    public function getDialogsByStatus(int $status): ActiveDataProvider
    {
        $query = UserTgBotDialog::find()->where(['status' => $status]);
        return new ActiveDataProvider(['query' => $query]);
    }

}