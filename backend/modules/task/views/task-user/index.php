<?php

use backend\modules\project\models\ProjectUser;
use backend\modules\task\models\Task;
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
                'filter' => Task::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'task.title'
            ],
            [
                'attribute' => 'project_user_id',
                'filter' => ProjectUser::find()->select(['user.username', 'project_user.id'])
                    ->joinWith('user')->indexBy('project_user.id')->column(),
                'value' => 'projectUser.user.username'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
