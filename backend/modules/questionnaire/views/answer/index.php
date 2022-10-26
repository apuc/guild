<?php

use backend\modules\questionnaire\models\Question;
use backend\modules\questionnaire\models\Questionnaire;
use common\helpers\AnswerHelper;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы на вопросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <p>
        <?= Html::a('Создать новый ответ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search_by_questionnaire', [
        'modelSearch' => $searchModel,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'filter' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
//                'label' => 'Анкета',
//                'attribute' => 'questionnaire',
//                'value' =>  'questionnaire.title'
//            ],
            [
                'filter' => Question::find()->select(['question_body', 'id'])
                    ->indexBy('id')->column(),
                'attribute' => 'question_id',
                'value' => 'question.question_body'
            ],
            'answer_body',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'filter' => AnswerHelper::answerFlagsList(),
                'value' => function ($model) {
                    return AnswerHelper:: answerFlagLabel($model->answer_flag);
                },
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

