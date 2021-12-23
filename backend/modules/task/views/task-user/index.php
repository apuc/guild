<?php

use backend\modules\project\models\ProjectUser;
use backend\modules\task\models\Task;
use backend\modules\task\models\TaskUser;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\task\models\TaskUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Исполнители задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-user-index">

    <p>
        <?= Html::a('Назначить сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search_by_project', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'task_id',
                'value' => 'task.title',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'task_id',
                    'data' => TaskUser::find()->joinWith('task')
                        ->select(['task.title', 'task.id'])->indexBy('task.id')->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250px',
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                ])
            ],
            [
                'attribute' => 'project_user_id',
                'value' => 'projectUser.card.fio',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_user_id',
                    'data' => TaskUser::find()->joinWith('projectUser.card')
                        ->select(['user_card.fio', 'task_user.id'])->column(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250px',
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
