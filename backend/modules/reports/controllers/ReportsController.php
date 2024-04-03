<?php

namespace backend\modules\reports\controllers;

use backend\modules\card\models\UserCardSearch;
use backend\modules\reports\models\ExtractForm;
use common\classes\Debug;
use common\models\ReportsTask;
use Yii;
use common\models\Reports;
use backend\modules\reports\models\ReportsSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
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
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportsSearch();
        $user_id__fio = ArrayHelper::map(ArrayHelper::toArray($searchModel->search([])->getModels(), [
            'common\models\Reports' => [
                'user_card_id',
                'fio' => function ($report) {
                    return Reports::getFio($report);
                }
            ],
        ]), 'user_card_id', 'fio');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index');
    }

    public function actionList()
    {
        $searchModel = new ReportsSearch();
        $user_id__fio = ArrayHelper::map(ArrayHelper::toArray($searchModel->search([])->getModels(), [
            'common\models\Reports' => [
                'user_card_id',
                'fio' => function ($report) {
                    return Reports::getFio($report);
                }
            ],
        ]), 'user_card_id', 'fio');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id__fio' => $user_id__fio,
        ]);
    }


    public function actionCalendar($user_id)
    {
        $searchModel = new ReportsSearch();
        $searchModel->user_id = $user_id;
        $dataProvider = $searchModel->search([]);


        $reports_array = ArrayHelper::toArray($dataProvider->getModels(), [
            'common\models\Reports' => [
                'id',
                'created_at',
                'difficulties',
                'tomorrow',
                'user_card_id',
                'today' => function ($report) {
                    return ArrayHelper::toArray($report->task, [
                        'common\models\ReportsTask' => [
                            'hours_spent',
                            'task'
                        ],
                    ]);
                }
            ],
        ]);

        if (!$dataProvider->getCount()) {
            return $this->render('non-exist_user_id', ['id' => $user_id]);
        }
        return $this->render('calendarOneUser', [
            'reports' => $reports_array,
            'fio' => Reports::getFio($searchModel),
            'USER_ID' => $user_id
        ]);

    }

    public function actionGroup()
    {
        $searchModel = new UserCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->innerJoin('reports', 'user_card.id = reports.user_card_id');

        return $this->render('group', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reports model.
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
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reports model.
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
     * Deletes an existing Reports model.
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

    public function actionExtractForm(): string
    {
        $model = new ExtractForm();

        return $this->render('extract-form', ['model' => $model]);
    }

    public function actionExtract()
    {
        $model = new ExtractForm();

        if ($model->load(Yii::$app->request->post())) {
            $query = ReportsTask::find()->joinWith('reports')
                ->where(['reports.user_id' => $model->user_id])
                ->andWhere(['between', 'reports.created_at', $model->date_from, $model->date_to]);

            $file = \Yii::createObject([
                'class' => 'codemix\excelexport\ExcelFile',
                'sheets' => [
                    'Reports' => [
                        'class' => 'codemix\excelexport\ActiveExcelSheet',
                        'query' => $query,
                        'attributes' => [
                            'reports.created_at',
                            'task',
                            'hours_spent'
                        ],
                    ]
                ]
            ]);

            $file->send('reports.xlsx');
        } else {
            return $this->render('extract-form', ['model' => $model]);
        }

    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
