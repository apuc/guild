<?php

use common\models\Project;
use common\models\UseStatus;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php  ?>
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'name',
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'name',
                    'data' => \common\models\Project::getListName(),
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            'budget',
            //'description:ntext',
            [
                'label' => 'Исполнители',
                'value' => function($model){
                    return implode(', ', $model->getUsersNameList());
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status0['name'];
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROJECT),
                    'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
