<?php

namespace backend\modules\document\controllers;

use backend\modules\company\models\CompanyManager;
use backend\modules\document\models\Document;
use backend\modules\document\models\DocumentSearch;
use common\services\DocumentService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
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
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
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
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Document();

        if ($model->load(Yii::$app->request->post()) &&  $model->validate()) {
            DocumentService::generateDocumentBody($model);
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Document model.
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
     * Deletes an existing Document model.
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
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownload($id): string
    {
        return $this->render('download', [
            'model' => Document::findOne($id)
        ]);
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionUpdateDocumentBody($id): string
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE_DOCUMENT_BODY;

        if ($model->load(Yii::$app->request->post())  && $model->validate()) {
            $model->updated_at = date('Y-m-d h:i:s');
            $model->save();
        }

        return $this->render('download', [
            'model' => $model
        ]);
    }

    public function actionDownloadPdf($id): string
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_DOWNLOAD_DOCUMENT;

        if ($model->validate()) {
            DocumentService::downloadPdf($id);
        }

        Yii::$app->session->setFlash('error', $model->getFirstError('body'));
        return $this->render('download', [
            'model' => Document::findOne($id)
        ]);
    }

    public function actionDownloadDocx($id): string
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_DOWNLOAD_DOCUMENT;

        if ($model->validate()) {
            DocumentService::downloadDocx($id);
        }

        Yii::$app->session->setFlash('error', $model->getFirstError('body'));
        return $this->render('download', [
            'model' => Document::findOne($id)
        ]);
    }

    public function actionManagers(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $company_id = $parents[0];
                /** @var CompanyManager[] $managers */
                $managers = CompanyManager::getManagersByCompany($company_id);

                $formattedManagersArr = array();
                foreach ($managers as $manager){
                    $formattedManagersArr[] = array('id' => $manager->id, 'name' => $manager->userCard->fio);
                }

                return ['output'=>$formattedManagersArr, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
}
