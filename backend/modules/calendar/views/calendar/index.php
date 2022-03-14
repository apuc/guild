<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Календарь ДР';
?>
<?= \backend\widgets\Calendar::widget([

    'css' => '.success{color: green;}',

    'button' => Html::a('<i class="fa fa-table" aria-hidden="true"></i> Таблица',
        ['table'], ['class' => 'btn btn-primary',]),

    'monthUpdate' => [
        'url' => Url::base() . '/calendar/ajax/get-birthday-dates-by-month'
    ],
    'dayUpdate' => [
        'url' => Url::base() . '/calendar/ajax/get-birthday-date'
    ],
    'colorClasses' => ['accept' => 'success', 'default' => '', 'offDay' => ''],
    'offDaysShow' => 0,

]) ?>


