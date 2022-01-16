<?php

namespace frontend\modules\api\controllers;

use common\services\TemplateService;
use yii\web\NotFoundHttpException;

class TemplateController extends ApiController
{

    public function verbs(): array
    {
        return [
            'get-template-list' => ['get'],
            'get-template-fields' => ['get'],
            'get-template' => ['get'],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTemplateList($document_type = null): array
    {
        $templateList = TemplateService::getTemplateList($document_type);

        if (empty($templateList)) {
            throw new NotFoundHttpException('No templates found');
        }

        return $templateList;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTemplateFields($template_id): array
    {
        if (empty($template_id) or !is_numeric($template_id)) {
            throw new NotFoundHttpException('Incorrect template ID');
        }

        $templateWithFields = TemplateService::getTemplateWithFields($template_id);

        if (empty($templateWithFields)) {
            throw new NotFoundHttpException('No template found');
        }

        return $templateWithFields;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGetTemplate($template_id): array
    {
        if (empty($template_id) or !is_numeric($template_id)) {
            throw new NotFoundHttpException('Incorrect template ID');
        }

        $template = TemplateService::getTemplate($template_id);

        if (empty($template)) {
            throw new NotFoundHttpException('No template found');
        }

        return $template;
    }
}
