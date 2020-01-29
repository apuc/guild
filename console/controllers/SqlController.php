<?php


namespace console\controllers;


use backend\modules\card\models\UserCard;
use Yii;
use yii\console\Controller;

class SqlController extends Controller
{
    public function actionSalary()
    {
        $sql = "UPDATE user_card SET salary=REPLACE( `salary`, ' ', '' )";
        Yii::$app->db->createCommand($sql)->execute();
        echo "script completed successfully\n";
    }

    public function actionGenerateUser()
    {
        echo UserCard::generateUserForUserCard() . "\n";
    }
}