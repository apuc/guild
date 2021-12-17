<?php

use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectUser;
use backend\modules\task\models\Task;
use common\helpers\StatusHelper;
use common\models\User;
use kartik\select2\Select2;
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
                'value' => 'project.name',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'project_id',
                    'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
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
            [
                'attribute' => 'user_id_creator',
                'value' => 'userIdCreator.username',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id_creator',
                    'data' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
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
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' =>  Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
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
            'description',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function($model){
                    return StatusHelper::statusLabel($model->status);
                }
            ],
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
