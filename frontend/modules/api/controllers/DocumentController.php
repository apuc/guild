<?php

namespace frontend\modules\api\controllers;

use common\models\Document;
use common\models\DocumentFieldValue;
use common\services\DocumentService;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class DocumentController extends ApiController
{

    public function verbs(): array
    {
        return [
            'get-document-list' => ['get'],
            'get-document' => ['get'],
            'create-document' => ['post'],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetDocumentList($document_type = null): array
    {
        $documents = DocumentService::getDocumentList($document_type);

        if(empty($documents)) {
            throw new NotFoundHttpException('Documents not found');
        }

        return $documents;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetDocument($document_id): array
    {
        if(empty($document_id) or !is_numeric($document_id))
        {
            throw new NotFoundHttpException('Incorrect document ID');
        }

        $document = DocumentService::getDocument($document_id);

        if(empty($document)) {
            throw new NotFoundHttpException('There is no such document');
        }

        return $document;
    }

    public function actionCreateDocument()
    {
        $document = Yii::$app->getRequest()->getBodyParams();
        $documentFieldValues = $document['documentFieldValues'];

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
        return  DocumentService::getDocument($modelDocument->id);
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
