<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\hh\models\HhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'hh.ru';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hh-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'hh_id',
            'url:url',
            'title',
            'dt_add:date',
            'photo:image',
            [
                'class' => 'yii\grid\DataColumn',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Получить вакансии', \yii\helpers\Url::to([
                        '/hh/hh/get-jobs',
                        'id' => $model->id
                    ]), [
                        'class' => 'btn btn-success'
                    ]);
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
</div>
