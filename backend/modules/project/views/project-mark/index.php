<?php

use backend\modules\project\models\Project;
use backend\modules\settings\models\Mark;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectMarkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метки проектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-mark-index">

    <p>
        <?= Html::a('Добавить проекту метку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project_id',
                'value' => function($model){
                    return $model->project->name;
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_id',
                    'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'mark_id',
                'value' => function($model){
                    return $model->mark->title;
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'mark_id',
                    'data' => Mark::find()->select(['title', 'id'])->indexBy('id')->column(),
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
