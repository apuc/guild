<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectColumnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Колонки проектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-column-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            [
                'attribute' => 'project_id',
                'value' => function(\common\models\ProjectColumn $model){
                    return $model->project->name ?? 'Не задано';
                }
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'status',
                'value' => function (\common\models\ProjectColumn $model) {
                    return \common\models\ProjectColumn::getStatus()[$model->status] ?? 'Не задано';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
