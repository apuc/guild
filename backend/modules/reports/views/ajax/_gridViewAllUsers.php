<?php

use common\models\Reports;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'format' => 'raw',
            'attribute' => 'user_card_id',
            'value' => function ($model) {
                return Html::a(Reports::getFio($model) . ' ' . Html::tag('i', null, ['class' => 'far fa-calendar-alt']),
                    \yii\helpers\Url::base(true) . '/reports/reports/calendar?user_id=' . $model['user_id'], ['data-pjax' => 0]);
            },
        ],
        [
            'attribute' => 'today',
            'format' => 'raw',
            'value' => function ($model) {

                $text = '';
                if ($model->task) {
                    $i = 1;
                    foreach ($model->task as $task) {
                        $text .= "<p>$i. ($task->hours_spent ч.) $task->task</p>";
                        $i++;
                    }
                }
                return $text;
            }
        ],
        'difficulties',
        'tomorrow',
        [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, $model, $key, $index) {
                return \yii\helpers\Url::base(true) . '/reports/reports/' . $action . '?id=' . $model->id;
            }
        ],
    ],

]);
die();

