<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'fio',
        'dob',
        ['class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, $model, $key, $index) {
                return \yii\helpers\Url::base(true) . '/calendar/calendar/' . $action . '?id=' . $model->id;
            }
        ],
    ],
]);
die();

