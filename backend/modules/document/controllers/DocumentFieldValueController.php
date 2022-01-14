<?php

namespace backend\modules\document\controllers;

use backend\modules\document\models\DocumentField;
use Yii;
use backend\modules\document\models\DocumentFieldValue;
use backend\modules\document\models\DocumentFieldValueSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocumentFieldValueController implements the CRUD actions for DocumentFieldValue model.
 */
class DocumentFieldValueController extends Controller
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
     * Lists all DocumentFieldValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentFieldValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentFieldValue model.
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
     * Creates a new DocumentFieldValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($document_id)
    {
        $model = new DocumentFieldValue();
        $model->document_id = $document_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($document_id !== null)
            {
                return $this->redirect(['document/view', 'id' => $document_id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new DocumentFieldValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateMultiple()
    {
        $document_id = Yii::$app->request->get('document_id');
        $template_id = Yii::$app->request->get('template_id');

        $fieldsIdTitleList = DocumentField::getIdFieldsTitleList($template_id);

        $documentFieldValues = [];

        if (empty($fieldsIdTitleList)) {
            return $this->redirect([
                'document/view',
                'id' => $document_id,
            ]);
        }
        else {
            foreach ($fieldsIdTitleList as $fieldsIdTitle){
                $tmpDocField = new DocumentFieldValue();
                $tmpDocField->document_id = $document_id;
                $tmpDocField->field_id = $fieldsIdTitle['id'];

                $documentFieldValues[] = $tmpDocField;
            }

            if (Model::loadMultiple($documentFieldValues, Yii::$app->request->post()) && Model::validateMultiple($documentFieldValues)) {
                foreach ($documentFieldValues as $documentFieldValue) {
                    $documentFieldValue->save(false);
                }

                return $this->redirect([
                    'document/view',
                    'id' => $document_id,
                ]);
            }
        }

        return $this->render('_form_multiple', [
            'documentFieldValues' => $documentFieldValues,
        ]);
    }

    /**
     * Updates an existing DocumentFieldValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $document_id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($document_id !== null)
            {
                return $this->redirect(['document/view', 'id' => $document_id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentFieldValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $document_id)
    {
        $this->findModel($id)->delete();

        if ($document_id !== null)
        {
            return $this->redirect(['document/view', 'id' => $document_id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocumentFieldValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentFieldValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentFieldValue::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
