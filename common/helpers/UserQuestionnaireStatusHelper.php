<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Exception;

class UserQuestionnaireStatusHelper
{
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_ON_INSPECTION = 3;

    public static function statusList() :array
    {
        return [
            self::STATUS_PASSIVE => 'Не используется',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_COMPLETED => 'Завершён',
            self::STATUS_ON_INSPECTION => 'На проверке'
        ];
    }

    public static function listCompleteStatuses(): array
    {
        return [
            self::STATUS_COMPLETED,
            self::STATUS_ON_INSPECTION
        ];

    }

    /**
     * @throws Exception
     */
    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    /**
     * @throws Exception
     */
    public static function statusLabel($status): string
    {
        switch ($status) {
            case self::STATUS_PASSIVE:
                $class = 'label label-danger';
                break;
            case ($status === self::STATUS_ACTIVE or $status === self::STATUS_COMPLETED):
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}