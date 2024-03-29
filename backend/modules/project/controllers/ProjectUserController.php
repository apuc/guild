<?php

namespace backend\modules\project\controllers;

use common\models\UserCard;
use Exception;
use Yii;
use backend\modules\project\models\ProjectUser;
use backend\modules\project\models\ProjectUserSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProjectUserController implements the CRUD actions for ProjectUser model.
 */
class ProjectUserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'as AccessBehavior' => [
                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectUser model.
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
     * Creates a new ProjectUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $post = \Yii::$app->request->post('ProjectUser');

        if (!empty($post)) {
            $card_id_arr = ArrayHelper::getValue($post, 'card_id');
            $project_id = $post['project_id'];

            foreach ($card_id_arr as $card_id) {
                $emtModel = new ProjectUser();
                $emtModel->project_id = $project_id;
                $emtModel->card_id = $card_id;
                $emtModel->user_id = UserCard::getUserIdByCardId($card_id);

                if (!$emtModel->save()) {
                    return $this->render('create', [
                        'model' => $emtModel,
                    ]);
                }
            }
            return $this->redirect(['index']);
        }

        $model = new ProjectUser();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProjectUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->user_id = UserCard::getUserIdByCardId($model->card_id);//UserCard::getIdByUserId($model->user_id);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetUserFields(): Response
    {
        ProjectUser::setUsersByCardId();

        return $this->redirect(['index']);
    }

    public function actionSetCardFields(): Response
    {
        ProjectUser::setCardsByUsersId();

        return $this->redirect(['index']);
    }

    public function actionUsersNotOnProject(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $project_id = $parents[0];
                $categories = ProjectUser::getUsersNotOnProject($project_id);

                $formattedCatArr = array();
                foreach ($categories as $key => $value){
                    $formattedCatArr[] = array('id' => $key, 'name' => $value);
                }

                return ['output'=>$formattedCatArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
}
