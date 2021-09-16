<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
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

