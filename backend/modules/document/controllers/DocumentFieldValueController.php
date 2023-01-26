<?php

namespace backend\modules\document\controllers;

use backend\modules\document\models\DocumentField;
use backend\modules\document\models\DocumentFieldValue;
use backend\modules\document\models\DocumentFieldValueSearch;
use Yii;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
    public function actionCreate()
    {
        $model = new DocumentFieldValue();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $fieldNames =  Yii::$app->request->get('fieldNames');

        // fields ID that should be saved in the document
        $documentFieldsIdList = ArrayHelper::getColumn(
                DocumentField::find()
                    ->where(['in', 'field_template', $fieldNames])
                    ->all(),
                'id');
        //already saved fields ID
        $fieldsValuesIdList = ArrayHelper::getColumn(
            DocumentFieldValue::find()->where(['document_id' => $document_id]) ->all(), 'document_field_id'
        );
        $fieldsIdList = array_diff($documentFieldsIdList, $fieldsValuesIdList);

        $fieldsWithError = [];
        $documentFieldValues = [];
        if (empty($fieldsIdList)) {
            return $this->redirect([
                'document/view',
                'id' => $document_id,
            ]);
        }
        else {
            foreach ($fieldsIdList as $id){
                $docFieldValue = new DocumentFieldValue();
                $docFieldValue->document_id = $document_id;
                $docFieldValue->document_field_id = $id;

                $documentFieldValues[] = $docFieldValue;
            }

            if (Model::loadMultiple($documentFieldValues, Yii::$app->request->post())) {
                foreach ($documentFieldValues as $documentFieldValue) {
                    if (!$documentFieldValue->save()) {
                        $fieldsWithError[] = $documentFieldValue;
                    }
                }

                if (!$fieldsWithError) {
                    return $this->redirect([
                        'document/write-fields',
                        'id' => $document_id,
                    ]);
                }
                $documentFieldValues = $fieldsWithError;
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
    public function actionUpdate($id, $fromDocument = null)
    {
        $model = $this->findModel($id);
        $oldValue = $model->value;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($fromDocument) {
                return $this->redirect([
                    'document/update-body',
                    'documentId' => $model->document_id,
                    'oldValue' => $oldValue,
                    'newValue' => $model->value
                ]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'fromDocument' =>$fromDocument,
        ]);
    }

    /**
     * Deletes an existing DocumentFieldValue model.
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
