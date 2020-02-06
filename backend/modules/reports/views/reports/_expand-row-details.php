<?php

use yii\grid\GridView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pages */

echo GridView::widget([
    'dataProvider' => $dataProvider,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'created_at',
        'today',
        'difficulties',
        'tomorrow',

        ['class' => 'yii\grid\ActionColumn'],
    ]
]);