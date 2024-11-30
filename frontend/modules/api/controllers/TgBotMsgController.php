<?php

namespace frontend\modules\api\controllers;

use common\models\TgBotMsg;
use frontend\modules\api\controllers\ApiController;

class TgBotMsgController extends ApiController
{
    public function actionGetToSend(): array|\yii\db\ActiveRecord|null
    {
        $msg = TgBotMsg::find()->where(['status' => TgBotMsg::STATUS_READY_TO_SEND])->orderBy('id ASC')->one();
        if ($msg){
            $msg->status = \common\models\Tgparsing::STATUS_SENT;
            $msg->save();

            return $msg;
        }

        return [];
    }


}