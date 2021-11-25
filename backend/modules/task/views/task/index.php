<?php

use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectUser;
use common\helpers\StatusHelper;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\task\models\TaskSearch */
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
                'filter' => ArrayHelper::map(Project::find()->all(), 'id', 'name'),
                'value' => 'project.name'
            ],
            'title',
            [
                'attribute' => 'project_user_id',
                'filter' => ProjectUser::find()->select(['username', 'project_user.id'])->joinWith('user')->indexBy('id')->column(),
                'value' => 'projectUser.user.username'
            ],
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                'value' => 'user.username'
            ],
            'description',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function ($model) {
                    return StatusHelper::statusLabel($model->status);
                },
            ],
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
