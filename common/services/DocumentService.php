<?php

namespace common\services;

use common\models\Document;

class DocumentService
{
    public static function getDocumentList($document_type): array
    {
        if (!empty($document_type)) {
            return Document::find()->joinWith('template')
                ->where(['document_type' => $document_type])->asArray()->all();
        }
        else {
            return Document::find()->asArray()->all();
        }
    }

    public static function getDocument($document_id)
    {
        return Document::find()
            ->joinWith(['documentFieldValues.field'])
            ->where(['document.id' => $document_id])
            ->asArray()->all();

    }
}