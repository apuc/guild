<?php

use backend\widgets\Calendar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Календарь отчетов';
?>

<?= Calendar::widget([

    'button' => Html::a('<i class="fas fa-long-arrow-alt-left"></i> Назад',
        Yii::$app->request->referrer, ['class' => 'btn btn-primary',]).
        Html::a('<i class="fa fa-list" aria-hidden="true"></i> Список',
            ['list'], ['class' => 'btn btn-success', 'style ' => 'margin: 0 5px']),


    'monthUpdate' => [
        'url' => Url::base() . '/reports/ajax/get-reports-for-month-by-id-year-month'
    ],
    'dayUpdate' => [
        'url' => Url::base() . '/reports/ajax/get-reports-for-day-by-date'
        ],
    'colorClasses' => ['accept' => 'success', 'default' => 'danger', 'offDay' => ''],
    'offDaysShow' => 1,

]) ?>
