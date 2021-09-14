<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\achievements\models\AchievementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Достижения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'title',
             'slug',
             'description',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\Achievement::getStatusLabel()[$model->status ?? 0];
                },
                'filter'    => kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => \common\models\Achievement::getStatusLabel(),
                    'options' => ['placeholder' => 'Начните вводить...', 'class' => 'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
