<?php

use backend\modules\questionnaire\models\Questionnaire;
use backend\modules\questionnaire\models\QuestionType;
use common\helpers\StatusHelper;
use common\helpers\TimeHelper;
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

    <?= $this->render('_search_by_questionnaire', [
        'model' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_body',
            [
                'attribute' => 'question_type_id',
                'filter' => QuestionType::find()->select(['question_type', 'id'])->indexBy('id')->column(),
                'value' => 'questionType.question_type'
            ],
//            [
//                'attribute' => 'questionnaire_id',
//                'filter' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
//                'value' => 'questionnaire.title',
//            ],
            'question_priority',
            'next_question',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function ($model) {
                    return StatusHelper::statusLabel($model->status);
                },
            ],
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => function($model){
                    return TimeHelper::limitTime($model->time_limit);
                }
            ],
            'score',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
