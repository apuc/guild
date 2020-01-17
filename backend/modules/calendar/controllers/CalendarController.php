<?php

namespace backend\modules\calendar\controllers;

use backend\modules\card\models\UserCardSearch;
use common\classes\Debug;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `calendar` module
 */
class CalendarController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserCardSearch();
        $user_card = \common\models\UserCard::find()->all();
        $user_array = array();
        try {
            if($_GET['month'] == 00)
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            else {
                foreach ($user_card as $value) {
                    if (substr(substr($value->dob, 5), 0, 2) == $_GET['month'])
                        array_push($user_array, $value);
                }
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $user_array,
                ]);
            }
        } catch (\Exception $e) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
