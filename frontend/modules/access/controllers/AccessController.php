<?php

namespace frontend\modules\access\controllers;

use common\classes\Debug;
use common\models\Accesses;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class AccessController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $id_user = Yii::$app->user->id;
        $query = "SELECT accesses.name, accesses.access FROM `accesses`, `user_card`, `user_card_accesses` WHERE user_card.id_user =" . $id_user . " AND user_card_accesses.user_card_id = user_card.id AND accesses.id = user_card_accesses.accesses_id ";
        $access = Accesses::findBySql($query);

        $dataProvider = new ActiveDataProvider([
            'query' => $access,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        return $this->render('index', compact('dataProvider', $dataProvider));
    }
}
