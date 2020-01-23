<?php

namespace backend\modules\card\controllers;

use common\classes\Debug;
use common\models\AdditionalFields;
use common\models\CardSkill;
use common\models\User;
use common\models\FieldsValue;
use common\models\FieldsValueNew;
use common\models\Status;
use Yii;
use backend\modules\card\models\UserCard;
use backend\modules\card\models\UserCardSearch;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserCardController implements the CRUD actions for UserCard model.
 */
class UserCardController extends Controller
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
        ];
    }

    /**
     * Lists all UserCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $total = 0;
        if(Yii::$app->request->queryParams)
            foreach (Yii::$app->request->queryParams as $params) {

                $total = \common\models\UserCard::find()->filterWhere([
                    'fio' => UserCard::getParameter($params, 'fio'),
                    'email' => UserCard::getParameter($params, 'email'),
                    'status' => UserCard::getParameter($params, 'status'),
                    'skills' => UserCard::getParameter($params, 'skills'),
                ])->sum('salary');
            }
        else $total = \common\models\UserCard::find()->sum('salary');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total' => $total,
        ]);
    }

    public function actionPassword($id)
    {
        $user_card = UserCard::findOne($id);
        $model = User::findOne(['id' => $user_card->id_user]);

        return $this->render('password', [
            'model' => $model,
        ]);
    }

    public function actionAjax() {
        if(Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $password = $_POST['password'];

            $user_card = UserCard::findOne($id);
            $user = User::findOne(['id' => $user_card->id_user]);
            $user->password = $password;
            $user->save();
        }
    }

    /**
     * Displays a single UserCard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
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

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelFildValue' => $dataProvider,
            'skills' => $skills,
            'userData' => User::findOne($id_current_user),
        ]);
    }

    /**
     * Creates a new UserCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            UserCard::generateUserForUserCard($model->id);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //CardSkill::deleteAll(['card_id' => $id]);
        //FieldsValue::deleteAll(['card_id' => $id]);
        $model = $this->findModel($id);
        $d = new \DateTime();
        $model->deleted_at = $d->format('Y-m-d H:i');
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Lists all UserCard models.
     * @return mixed
     */
    public function actionGenerate()
    {
        $massage = UserCard::generateUserForUserCard();
        return $this->render('generate', ['massage' => $massage]);
    }


    /**
     * Finds the UserCard model based on its primary key value.
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
