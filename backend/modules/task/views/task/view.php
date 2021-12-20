<?php

use common\helpers\StatusHelper;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\Task */
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
                'attribute' => 'card_id_creator',
                'value' => ArrayHelper::getValue($model, 'userCardCreator.fio'),
            ],
            [
                'attribute' => 'card_id',
                'value' => ArrayHelper::getValue($model, 'userCard.fio'),
            ],
            'description',
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Исполнители' ?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $taskDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'project_user_id',
                'value' => 'projectUser.user.username'
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
