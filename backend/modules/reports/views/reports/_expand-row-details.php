<?php

use yii\grid\GridView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pages */

echo GridView::widget([
    'dataProvider' => $dataProvider,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'created_at',
        [
            'attribute' => 'today',
            'format' => 'raw',
            'value' => function ($model) {
                $text = '';
                if ($model->task) {
                    $i = 1;
                    foreach ($model->task as $task) {
                        $text .= "<p>$i. ($task->hours_spent ч., $task->minutes_spent мин.) $task->task</p>";
                        $i++;
                    }
                }
                return $text;
            }
        ],
        'difficulties',
        'tomorrow',

        ['class' => 'yii\grid\ActionColumn'],
    ]
]);