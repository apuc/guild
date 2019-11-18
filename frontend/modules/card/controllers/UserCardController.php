<?php


namespace frontend\modules\card\controllers;

use common\models\CardSkill;
use common\models\FieldsValueNew;
use common\models\User;
use Yii;
use common\models\UserCard;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserCardController extends Controller
{
    /**
     * Displays a single Product model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
       /* $id_user = Yii::$app->user->id;
        $id = UserCard::find()->where(['id_user' => $id_user])->asArray()->all();

        return $this->render('index', [
            'model' => $this->findModel($id[0]['id']),
        ]);*/

        $id_user = Yii::$app->user->id;
        $result = UserCard::find()->where(['id_user' => $id_user])->asArray()->all();
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

        $id_current_user = $this->findModel($id)->id_user;

        return $this->render('index', [
            'model' => $this->findModel($id),
            'modelFildValue' => $dataProvider,
            'skills' => $skills,
            // 'userData' => $userData,
            //userData' => User::findOne($id_current_user),
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