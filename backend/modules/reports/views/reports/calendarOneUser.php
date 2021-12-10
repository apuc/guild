<?php

use backend\widgets\Calendar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $fio */
/* @var $USER_ID */

$this->title = 'Календарь пользователя - ' . $fio;
?>

<?= Calendar::widget([

    'button' => Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад',
        Yii::$app->request->referrer, ['class' => 'btn btn-primary',]),

    'monthUpdate' => [
        'url' => Url::base() . '/reports/ajax/get-reports-for-month-by-id-year-month',
        'data' => ['user_id' => $USER_ID]
    ],
    'dayUpdate' => [
        'url' => Url::base() . '/reports/ajax/get-reports-for-day-by-date',
        'data' => ['user_id' => $USER_ID]
        ],
    'colorClasses' => ['accept' => 'success', 'default' => 'warning', 'fail' => 'danger', 'offDay' => ''],
    'offDaysShow' => 1,
    'failDay' => 1,

]) ?>
