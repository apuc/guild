<?php

namespace backend\modules\calendar\controllers;

use backend\modules\card\models\UserCardSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `calendar` module
 */
class CalendarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'as AccessBehavior' => [
                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }

    public function actionTable()
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

        return $this->render('table', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
