<?php


namespace frontend\modules\reports\models;

use common\classes\Debug;
use common\models\UserCard;
use Yii;

class Reports extends \common\models\Reports
{
    public function init()
    {
        parent::init();
    }

//    public function beforeSave($insert)
//    {
//        $user_card = UserCard::findOne(['id_user' => Yii::$app->user->identity->id]);
//        $this->user_card_id = $user_card->id;
//        return parent::beforeSave($insert);
//    }

    public function beforeValidate()
    {
        if (empty($this->user_card_id)) {
            $user_card = UserCard::findOne(['id_user' => Yii::$app->user->identity->id]);
            $this->user_card_id = $user_card->id;
        }
        return parent::beforeValidate();
    }
}