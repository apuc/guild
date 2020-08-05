<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отпуска';
$this->params['breadcrumps'][] = $this->title;
?>
<?= Html::a('Назад', ['index'], ['class' => 'btn btn-success']) ?>
<div class="holiday-calendar">
    <?= \edofre\fullcalendarscheduler\FullcalendarScheduler::widget([
        'header'        => [
            'left'   => 'today prev,next',
            'center' => 'title',
        ],
        'clientOptions' => [
            'now'               => date("Y/m/d"),
            'editable'          => false,
            'aspectRatio'       => 2.4,
            'scrollTime'        => '00:00', // undo default 6am scrollTime
            'defaultView'       => 'month',
            ],
            'events'            => $events,
    ]);
    ?>
</div>
