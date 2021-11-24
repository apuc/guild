<?php

use backend\modules\project\models\Project;
use common\helpers\StatusHelper;
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
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function ($model) {
                    return StatusHelper::statusLabel($model->status);
                },
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
