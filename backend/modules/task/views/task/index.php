<?php

use backend\modules\card\models\UserCard;
use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectUser;
use backend\modules\task\models\ProjectTask;
use common\helpers\StatusHelper;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\task\models\ProjectTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_id',
                    'data' => ProjectTask::find()->joinWith('project')
                        ->select(['project.name', 'project.id'])->indexBy('project.id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '150px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],
            'title',
            'description',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function($model){
                    return StatusHelper::statusLabel($model->status);
                }
            ],
//            [
//                'attribute' => 'priority',
//                'format' => 'raw',
//                'filter' => ProjectTask::priorityList(),
//                'value' => function($model){
//                    return ProjectTask::getPriority($model->status);
//                }
//            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.Y H:i']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:d.m.Y H:i']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
