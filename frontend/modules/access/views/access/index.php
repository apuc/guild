<?php

use yii\grid\GridView;
use yii\widgets\DetailView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'access',
    ],
]);
