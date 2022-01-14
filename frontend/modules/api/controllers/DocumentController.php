<?php

namespace frontend\modules\api\controllers;

use common\models\Document;
use common\models\DocumentFieldValue;
use common\models\Template;
use common\models\TemplateDocumentField;
use Exception;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

class DocumentController extends ApiController
{

    public function verbs(): array
    {
        return [
//            'get-task' => ['get'],
            'get-document-list' => ['get'],
            'create-document' => ['post'],
//            'update-task' => ['put', 'patch'],
        ];
    }

    public function actionGetDocumentList(): array
    {
        $documents = Document::find()->select(['id','title', 'manager_id'])->all();

        if(empty($documents)) {
            throw new NotFoundHttpException('Documents are not assigned');
        }

        return $documents;
    }

    public function actionGetDocument(): array
    {
        $document_id = Yii::$app->request->get('document_id');
        if(empty($document_id) or !is_numeric($document_id))
        {
            throw new NotFoundHttpException('Incorrect document ID');
        }

        $document = Document::getDocument($document_id);

        if(empty($document)) {
            throw new NotFoundHttpException('There is no such document');
        }

        return $document;
    }

    public function actionCreateDocument()
    {
        $document = Yii::$app->getRequest()->getBodyParams();
        $documentFieldValues = Yii::$app->getRequest()->getBodyParams()['documentFieldValues'];

        $tmp =  TemplateDocumentField::find()->select('field_id')
            ->where(['template_id' => 94])->asArray()->all();

        $modelDocument = new Document();
        if ($modelDocument->load($document, '') && $modelDocument->save()) {

            try {
                $this->createDocimentFields($documentFieldValues, $modelDocument->id, $modelDocument->template_id);
            }
            catch (ServerErrorHttpException $e) {
                $modelDocument->delete();
                throw new BadRequestHttpException(json_encode($e->getMessage()));
            }
        }
        else {
            throw new BadRequestHttpException(json_encode($modelDocument->errors));
        }

        Yii::$app->getResponse()->setStatusCode(201);
        return  Document::getDocument($modelDocument->id);
    }

    private function createDocimentFields($documentFieldValues , $document_id, $template_id)
    {
        if (!empty($documentFieldValues)) {

            $modelFieldsArray = array();

            foreach ($documentFieldValues as $docFieldValue) {
                $tmpModelField = new DocumentFieldValue();

                if ($tmpModelField->load($docFieldValue, '')) {
                    $modelFieldsArray[] = $tmpModelField;
                }
                else {
                    throw new ServerErrorHttpException(
                        'Failed to load document field value where modelField: field_id=' . $tmpModelField->field_id . ' value=' . $tmpModelField->value);
                }
            }

            foreach ($modelFieldsArray as $modelField) {

                $modelField->document_id = $document_id;
                if (!$modelField->save()) {
                    throw new ServerErrorHttpException(
                        'Failed to save document field value where modelField: field_id=' . $modelField->field_id . ' value=' . $modelField->value);
                }
            }
        }
    }
}
