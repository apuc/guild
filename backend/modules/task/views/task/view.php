<?php

use backend\modules\task\models\ProjectTask;
use common\helpers\StatusHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTask */
/* @var $taskDataProvider yii\data\ActiveDataProvider */

$this->title = 'Задача: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="task-view">

    <p>
        <?= Html::a('Список', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'project_id',
                'value' => ArrayHelper::getValue($model, 'project.name')
            ],
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => StatusHelper::statusLabel($model->status),
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'column_id',
                'value' => ArrayHelper::getValue($model, 'column.title'),
            ],
            [
                'attribute' => 'user_id',
                'value' => ArrayHelper::getValue($model, 'user.userCard.fio'),
            ],
            [
                'attribute' => 'executor_id',
                'value' => ArrayHelper::getValue($model, 'executor.userCard.fio'),
            ],
            'description',
            [
                'attribute' => 'priority',
                'value' => function($model){
                    return ProjectTask::getPriority($model->status);
                }
            ],
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Участники' ?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $taskDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project_user_id',
                'value' => 'user.email'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'task-user',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['task-user/update', 'id' => $model['id'], 'task_id' => $model['task_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'task-user/delete', 'id' => $model['id'], 'task_id' => $model['task_id']
                            ],
                            [
                                'data' => ['confirm' => 'Вы уверены, что хотите удалить этого сотрудника?', 'method' => 'post']
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a(
            'Назначить исполнителя',
            ['task-user/create', 'task_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
