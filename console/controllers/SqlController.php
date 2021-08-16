<?php


namespace console\controllers;


use common\models\UserCard;
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

    public function actionAddAva()
    {
        $model = UserCard::find()->all();
        foreach ($model as $item) {
            if(!$item->photo){
                if($item->gender === 1){
                    $item->photo = '/profileava/f' . random_int(1, 6) . '.png';
                }
                else {
                    $item->photo = '/profileava/m' . random_int(1, 10) . '.png';
                }
                $item->save();
            }
        }
        echo "script completed successfully\n";
    }

    public function actionGenerateUser()
    {
        echo UserCard::generateUserForUserCard() . "\n";
    }
}