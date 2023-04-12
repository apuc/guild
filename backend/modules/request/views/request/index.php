<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\request\models\RequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить запрос', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'created_at',
            //'updated_at',
            [
                'attribute' => 'user_id',
                'value' => function(\common\models\Request $model){
                    return $model->user->userCard->fio ?? 'Не задано';
                }
            ],
            'title',
            [
                'attribute' => 'position_id',
                'value' => function(\common\models\Request $model){
                    return $model->position->name ?? 'Не задано';
                }
            ],
            //'skill_ids',
            [
                'attribute' => 'knowledge_level_id',
                'value' => function(\common\models\Request $model){
                    return \common\models\UserCard::getLevelList()[$model->knowledge_level_id];
                }
            ],
            //'descr:ntext',
            'specialist_count',
            [
                'attribute' => 'status',
                'value' => function(\common\models\Request $model){
                    return \common\models\KnowledgeLevel::getStatus()[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
