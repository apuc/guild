<?php


namespace frontend\modules\card\controllers;

use common\classes\Debug;
use common\models\AchievementUserCard;
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
        echo $id_user;
//        die();
        $result = UserCard::find()->where(['id_user' => $id_user])->asArray()->all();
        if($result) {
            $id = $result[0]['id'];
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                $model->updated_at = date('Y-m-d h:i:s');
                $model->save();
            }
            $dataProvider = new ActiveDataProvider([
                'query' => FieldsValueNew::find()
                    ->where(['item_id' => $id, 'item_type' => FieldsValueNew::TYPE_PROFILE])
                    ->orderBy('order'),
                'pagination' => [
                    'pageSize' => 200,
                ],
            ]);

            $skills = CardSkill::find()->where(['card_id' => $id])->with('skill')->all();
            $achievements = AchievementUserCard::find()
                ->where(['user_card_id' => $id])
                ->innerJoinWith(['achievement' => function($query) {
                    $query->andWhere(['status' => \common\models\Achievement::STATUS_ACTIVE]);
                }])
                ->all();

            return $this->render('view', [
                'model' => $model,
                'modelFildValue' => $dataProvider,
                'skills' => $skills,
                'achievements' => $achievements,
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

    public function actionResume()
    {
        $id_user = Yii::$app->user->id;
        $result = UserCard::find()->where(['id_user' => $id_user])->asArray()->all();
        if ($result) {
            $id = $result[0]['id'];
            $model = $this->findModel($id);
            return $this->render('resume', [
                'model' => $model
            ]);
        } else {
            return $this->render('index', ['info' => '<h3>Ваши личные данные не заненсены в базу.</h3>']);
        }
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