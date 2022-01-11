<?php

namespace frontend\modules\api\controllers;

use common\models\Document;
use common\models\DocumentFieldValue;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;

class DocumentFieldValueController extends Controller
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
            'document-field-value-list' => ['get'],
//            'create-task' => ['post'],
//            'update-task' => ['put', 'patch'],
        ];
    }

    public function actionDocumentFieldValueList(): array
    {
        $document_id = Yii::$app->request->get('document_id');
        if(empty($document_id) or !is_numeric($document_id))
        {
            throw new NotFoundHttpException('Incorrect document ID');
        }

        $fieldValues = DocumentFieldValue::find()
            ->where(['document_id' => $document_id])
            ->all();

        if(empty($fieldValues)) {
            throw new NotFoundHttpException('There is no such fields');
        }

        return $fieldValues;
    }
}
