<?php

namespace backend\modules\task\controllers;

use backend\modules\project\models\ProjectUser;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Yii;
use backend\modules\task\models\TaskUser;
use backend\modules\task\models\TaskUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
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
     * Lists all TaskUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskUser model.
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
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate($task_id = null)
    {
        $post = \Yii::$app->request->post('TaskUser');

        if (!empty($post)) {
            $project_user_id_arr = ArrayHelper::getValue($post, 'project_user_id');

            foreach ($project_user_id_arr as $project_user_id) {
                $emtModel = new TaskUser();
                $emtModel->task_id = $post['task_id'];
                $emtModel->project_user_id = $project_user_id;

                if (!$emtModel->save()) {
                    return $this->render('create', [
                        'model' => $emtModel,
                        'task_id' => $task_id,
                    ]);
                }
            }

            if ($task_id !== null)
            {
                return $this->redirect(['task/view', 'id' => $task_id]);
            }

            return $this->redirect(['index']);
        }


        $model = new TaskUser();
        return $this->render('create', [
            'model' => $model,
            'task_id' => $task_id,
        ]);
    }

    /**
     * Updates an existing TaskUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $task_id = null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($task_id !== null)
            {
                return $this->redirect(['task/view', 'id' => $task_id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'task_id' => $task_id === null ? $model->task_id: $task_id,
        ]);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $task_id = null)
    {
        $this->findModel($id)->delete();

        if ($task_id !== null)
        {
            return $this->redirect(['task/view', 'id' => $task_id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExecutor()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $task_id = $parents[0];
                $users = ProjectUser::userCardByTaskArr($task_id);

                $formattedUsersArr = array();
                foreach ($users as $key => $value){
                    $formattedUsersArr[] = array('id' => $key, 'name' => $value);
                }

                return ['output'=>$formattedUsersArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
}
