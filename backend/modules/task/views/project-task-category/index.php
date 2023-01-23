<?php

use backend\modules\project\models\Project;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\task\models\ProjectTaskCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории задач проекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-task-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать категорию задач', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_id',
                    'data' => Project::find()->select(['project.name', 'project.id'])
                        ->indexBy('project.id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
