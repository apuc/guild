<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\hh\models\HhJobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $hhCompanies array */

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hh-job-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'employer_id',
                'value' => function ($model) {
                    return isset($model->hhcompany->title) ? $model->hhcompany->title : '';
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'employer_id',
                    'data' => $hhCompanies,
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            //'hh_id',
            'title',
            'url:url',
            'salary_from',
            'salary_to',
            'salary_currency',
            'address',
            'dt_add:date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
</div>
