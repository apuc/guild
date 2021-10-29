<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список вопросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <p>
        <?= Html::a('Создать вопрос', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_body',
            [
                'attribute' => 'question_type_id',
                'value' => function($model){
                    return  $model->getQuestionTitle();
                }
            ],
            [
                'attribute' => 'questionnaire_id',
                'value' => function($model){
                    return  $model->getQuestionnaireTitle();
                }
            ],
            'question_priority',
            'next_question',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => \common\helpers\StatusHelper::statusList(),
                'value' => function ($model) {
                    return \common\helpers\StatusHelper::statusLabel($model->status);
                },
            ],
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return \common\helpers\TimeHelper::limitTime($model->time_limit);
                }
            ],
            'score',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
