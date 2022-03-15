<?php

use backend\modules\test\models\TestTask;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\test\models\TestTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тестовые задания';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-task-index">

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'description',
            [
                'attribute' => 'link',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->link), Url::to($model->link));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'level',
                'format' => 'raw',
                'filter' => TestTask::getLevelList(),
                'value' => function($model){
                    return TestTask::getLevelLabel($model->level);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function($model){
                    return StatusHelper::statusLabel($model->status);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
