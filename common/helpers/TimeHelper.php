<?php

namespace common\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TimeHelper
{
    public static function limitTime($time_limit)
    {
        if ($time_limit === null)
        {
            return 'Не ограниченоTEST';
        }

        return date("H:i:s", mktime(null, null, $time_limit)) . ' (HH:mm:ss)';

//        $date
//        return Html::tag('span', $date, ['class' => 'label label-primary']);
    }

}