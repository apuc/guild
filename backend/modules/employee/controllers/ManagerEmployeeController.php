<?php

namespace backend\modules\employee\controllers;

use Yii;
use backend\modules\employee\models\ManagerEmployee;
use backend\modules\employee\models\ManagerEmployeeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManagerEmployeeController implements the CRUD actions for ManagerEmployee model.
 */
class ManagerEmployeeController extends Controller
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
     * Lists all ManagerEmployee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManagerEmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ManagerEmployee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ManagerEmployee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {




        $post = $post = \Yii::$app->request->post('ManagerEmployee');

        if (!empty($post)) {
            $user_card_id_arr = ArrayHelper::getValue($post,'user_card_id');

            foreach ($user_card_id_arr as $user_card_id) {
                $emtModel = new ManagerEmployee();
                $emtModel->manager_id = $post['manager_id'];
                $emtModel->user_card_id = $user_card_id;

                if (!$emtModel->save()) {
                    return $this->render('create', [
                        'model' => $emtModel,
                    ]);
                }
            }

            return $this->redirect(['index']);
        }

        $model = new ManagerEmployee();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ManagerEmployee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $manager_id = null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($manager_id !== null)
            {
                return $this->redirect(['manager/view', 'id' => $manager_id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ManagerEmployee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $manager_id = null)
    {
        $this->findModel($id)->delete();

        if ($manager_id !== null)
        {
            return $this->redirect(['manager/view', 'id' => $manager_id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ManagerEmployee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ManagerEmployee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ManagerEmployee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
