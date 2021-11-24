<?php

use backend\modules\project\models\ProjectUser;
use backend\modules\task\models\Task;
use yii\helpers\ArrayHelper;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'task_id',
                'filter' => ArrayHelper::map(Task::find()->all(), 'id', 'title'),
                'value' => 'task.title'
            ],
            [
                'attribute' => 'project_user_id',
                'filter' => ArrayHelper::map(ProjectUser::find()->joinWith('user')
                    ->all(), 'id', 'user.username'),
                'value' => 'projectUser.user.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
