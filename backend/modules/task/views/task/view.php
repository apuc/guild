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
                'attribute' => 'project_user_id',
                'value' => ArrayHelper::getValue($model, 'projectUser.user.username'),
            ],
            [
                'attribute' => 'user_id',
                'value' => ArrayHelper::getValue($model, 'user.username'),
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
                'attribute' => 'task_id', // ArrayHelper::map(Task::find()->all(), 'id', 'title'),
                'value' => 'task.title'
            ],
            [
                'attribute' => 'project_user_id',
                'value' => 'projectUser.user.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
