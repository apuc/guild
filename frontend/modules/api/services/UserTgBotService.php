<?php

namespace frontend\modules\api\services;

use common\models\UserTgBotDialog;
use frontend\modules\api\models\tg_bot\UserTgBotToken;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserTgBotService
{

    public function getDialogsByStatus(int $status): ActiveDataProvider
    {
        $query = UserTgBotDialog::find()->where(['status' => $status]);
        return new ActiveDataProvider(['query' => $query]);
    }

    public static function getDialogs(): array
    {
        $list = UserTgBotDialog::find()->all();

        return ArrayHelper::map($list, "dialog_id", "username");
    }

}