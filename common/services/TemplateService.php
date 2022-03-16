<?php

namespace common\services;

use common\models\Template;

class TemplateService
{
    public static function getTemplateList($document_type = null): array
    {
        if (!empty($document_type)) {
            return Template::find()->where(['document_type' => $document_type])->asArray()->all();
        }
        else {
            return Template::find()->asArray()->all();
        }
    }

    public static function getTemplateWithFields($template_id): array
    {
        return Template::find()
            ->joinWith('templateDocumentFields.field')
            ->where(['template.id' => $template_id])
            ->asArray()
            ->one();
    }

    public static function getTemplate($template_id): array
    {
        return Template::find()->where(['template.id' => $template_id])
            ->asArray()
            ->one();
    }
}