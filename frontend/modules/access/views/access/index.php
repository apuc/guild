<?php

use yii\grid\GridView;

$this->title = 'Доступы';

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'access',
    ],
]);
