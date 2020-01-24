<?php


namespace console\controllers;


use Yii;
use yii\console\Controller;

class SqlController extends Controller
{
    public function actionSalary()
    {
        $sql = "UPDATE user_card SET salary=REPLACE( `salary`, ' ', '' )";
        Yii::$app->db->createCommand($sql)->execute();
    }
}