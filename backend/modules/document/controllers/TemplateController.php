<?php

namespace backend\modules\document\controllers;

use Yii;
use backend\modules\document\models\Template;
use backend\modules\document\models\TemplateSearch;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $templateFieldDataProvider = new ActiveDataProvider([
            'query' => $model->getTemplateDocumentFields(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'templateFieldDataProvider' => $templateFieldDataProvider,
        ]);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($model->load(Yii::$app->request->post())) {
            $model->template = UploadedFile::getInstance($model, 'template');

            if (!empty($model->template)) {
                $pathToTemplates = Yii::getAlias('@templates');
                $model->template_file_name = date('mdyHis') . '_' . $model->template->name;

                if ($model->save()) {
                    if (FileHelper::createDirectory($pathToTemplates, $mode = 0775, $recursive = true)) {
                        $model->template->saveAs($pathToTemplates . '/' . $model->template_file_name);
                    }
                    return $this->redirect(['template-document-field/create', 'template_id' => $model->id]);
                }
                return $this->render('create', ['model' => $model]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

//    /**
//     * Updates an existing Template model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    public function actionUpdateTitle($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Template::SCENARIO_UPDATE_TITLE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form_update_title', [
            'model' => $model,
        ]);
    }

    public function actionUpdateFile($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Template::SCENARIO_UPDATE_FILE;

        if ($model->load(Yii::$app->request->post())) {
            $model->template = UploadedFile::getInstance($model, 'template');

            if (!empty($model->template)) {
                $pathToTemplates = Yii::getAlias('@templates');

                unlink($pathToTemplates . '/' . $model->template_file_name);

                $model->template_file_name = date('mdyHis') . '_' . $model->template->name;

                if ($model->save()) {
                    if (FileHelper::createDirectory($pathToTemplates, $mode = 0775, $recursive = true)) {
                        $model->template->saveAs($pathToTemplates . '/' . $model->template_file_name);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('_form_update_file', ['model' => $model]);
            }
        }

        return $this->render('_form_update_file', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Template model.
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
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
