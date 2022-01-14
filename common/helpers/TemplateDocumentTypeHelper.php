<?php

namespace common\helpers;

use Exception;
use yii\helpers\ArrayHelper;

class TemplateDocumentTypeHelper
{
    const STATUS_ACT = 1;
    const STATUS_CONTRACT = 2;

    public static function getDocumentTypeList() :array
    {
        return [
            self::STATUS_ACT => 'Акт',
            self::STATUS_CONTRACT => 'Договор'
        ];
    }

    /**
     * @throws Exception
     */
    public static function getDocumentType($document_type)
    {
        if (!$document_type) {
            return ArrayHelper::getValue(self::getDocumentTypeList(), $document_type);
        }
        return $document_type;
    }
}