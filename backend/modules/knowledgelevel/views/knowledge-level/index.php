<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\knowledgelevel\models\KnowledgeLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Уровень знаний';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-level-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return \common\models\KnowledgeLevel::getStatus()[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
