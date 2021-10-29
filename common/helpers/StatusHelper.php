<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Exception;

class StatusHelper
{
    const STATUS_PASSIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function statusList() :array
    {
        return [
            self::STATUS_PASSIVE => 'Не используется',
            self::STATUS_ACTIVE => 'Активен'
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
            case self::STATUS_ACTIVE:
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