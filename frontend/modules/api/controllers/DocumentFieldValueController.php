<?php

namespace frontend\modules\api\controllers;

use common\models\DocumentFieldValue;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

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
            'update' => ['post'],
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

    public function actionUpdate()
    {
        $model = $this->findModelDocumentFieldValue(Yii::$app->request->post('document_field_value_id'));
        if(empty($model)) {
            throw new NotFoundHttpException('The document field value does not exist');
        }

        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

    private function findModelDocumentFieldValue($document_field_value_id)
    {
        return DocumentFieldValue::findOne($document_field_value_id);
    }
}
