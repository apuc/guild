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
                    $html = Html::a('Получить все вакансии', \yii\helpers\Url::to([
                        '/hh/hh/get-jobs',
                        'id' => $model->id
                    ]), [
                        'class' => 'btn btn-success'
                    ]);
                    $html = $html . '<br><br>' . $html = Html::a('Только "удаленная работа"', \yii\helpers\Url::to([
                            '/hh/hh/get-jobs-remote',
                            'id' => $model->id
                        ]), [
                            'class' => 'btn btn-success'
                        ]);
                    return $html;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
</div>
