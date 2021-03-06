<?php


namespace frontend\modules\card\controllers;

use common\classes\Debug;
use common\models\CardSkill;
use common\models\FieldsValueNew;
use common\models\User;
use Yii;
use frontend\modules\card\models\UserCard;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserCardController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays a single Product model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
        $id_user = Yii::$app->user->id;
        $result = UserCard::find()->where(['id_user' => $id_user])->asArray()->all();

        if($result) {
            $id = $result[0]['id'];
            $dataProvider = new ActiveDataProvider([
                'query' => FieldsValueNew::find()
                    ->where(['item_id' => $id, 'item_type' => FieldsValueNew::TYPE_PROFILE])
                    ->orderBy('order'),
                'pagination' => [
                    'pageSize' => 200,
                ],
            ]);

            $skills = CardSkill::find()->where(['card_id' => $id])->with('skill')->all();
            return $this->render('view', [
                'model' => $this->findModel($id),
                'modelFildValue' => $dataProvider,
                'skills' => $skills,
            ]);
        }
        else return $this->render('index', ['info' => '<h3>Ваши личные данные не заненсены в базу.</h3>']);
    }

    public function actionUpdate()
    {
        $model = UserCard::findOne(['id_user' => Yii::$app->user->identity->id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPassword()
    {
        $model = User::findOne(Yii::$app->user->identity->id);

        if (Yii::$app->request->post()) {
            $model->setPassword(Yii::$app->request->post()['password']);
            $model->save();

            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('password', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}