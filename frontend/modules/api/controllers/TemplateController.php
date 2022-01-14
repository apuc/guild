<?php

namespace frontend\modules\api\controllers;

use common\models\Document;
use common\models\Template;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TemplateController extends ApiController
{

    public function verbs(): array
    {
        return [
            'get-template-list' => ['get'],
            'get-template-fields' => ['get'],
        ];
    }

    public function actionGetTemplateList(): array
    {
        $template = Template::find()->asArray()->all();

        if (empty($template)) {
            throw new NotFoundHttpException('Documents are not assigned');
        }

        return $template;
    }

    public function actionGetTemplateFields(): array
    {
        $template_id = Yii::$app->request->get('template_id');
        if (empty($template_id) or !is_numeric($template_id)) {
            throw new NotFoundHttpException('Incorrect template ID');
        }

        $templates = Template::find()
            ->joinWith('templateDocumentFields.field')
            ->where(['template.id' => $template_id])
            ->asArray()
            ->all();

        if (empty($templates)) {
            throw new NotFoundHttpException('Documents are not assigned');
        }

        return $templates;
    }
}
