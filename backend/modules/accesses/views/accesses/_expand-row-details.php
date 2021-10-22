<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $searchModel app\modules\accesses\models\AccessesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'login',
        'password',
        'link',
        'project',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'delete' => function ($data) {
                    return Html::a("<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>",
                        ['/accesses/accesses/custom-delete', 'id' => $data]);
                },
            ],
        ],
    ]
]);