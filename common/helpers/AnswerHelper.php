<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;
use Exception;
use yii\helpers\Html;

class AnswerHelper
{
    const FLAG_TRUE = 1;
    const FLAG_FALSE = 0;

    public static function answerFlagsList(): array
    {
        return [
            self::FLAG_TRUE => 'Верен',
            self::FLAG_FALSE => 'Ошибочный',
        ];
    }

    /**
     * @throws Exception
     */
    public static function statusLabel($status): string
    {
        switch ($status) {
            case self::FLAG_FALSE:
                $class = 'label label-danger';
                break;
            case self::FLAG_TRUE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::answerFlagsList(), $status), [
            'class' => $class,
        ]);
    }
}