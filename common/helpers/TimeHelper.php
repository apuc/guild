<?php

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TimeHelper
{
    public static function limitTime($time_limit)
    {
        if ($time_limit === null)
        {
            return 'Не ограничено';
        }

        return Html::tag(
            'span',
            Yii::$app->formatter->asDuration(strtotime($time_limit, '0')),
            ['class' => 'label label-primary']
        );
    }
}