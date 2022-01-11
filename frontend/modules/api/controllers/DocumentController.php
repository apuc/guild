<?php

namespace frontend\modules\api\controllers;

use common\models\Document;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;

class DocumentController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function verbs(): array
    {
        return [
//            'get-task' => ['get'],
            'get-document-list' => ['get'],
//            'create-task' => ['post'],
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

        $document = Document::find()
        ->joinWith(['documentFieldValues.field'])
        ->where(['document.id' => $document_id])
        ->asArray()
        ->all();

        if(empty($document)) {
            throw new NotFoundHttpException('There is no such document');
        }

        return $document;
    }
}
