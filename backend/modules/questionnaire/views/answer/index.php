<?php

use backend\modules\questionnaire\models\Question;
use common\helpers\AnswerHelper;
use common\helpers\StatusHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы на вопросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый ответ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<!--    --><?php
//
//    echo Select2::widget([
//        'model' => \backend\modules\questionnaire\models\Questionnaire::findOne()->where(['id'=>1]),
//        'attribute' => 'state_2',
//        'data' => 1,
//        'options' => ['placeholder' => 'Select a state ...'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
//
//    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'filter' => Question::find()->select(['question_body', 'id'])->where(['!=', 'question_type_id', '1'])->indexBy('id')->column(),
                'attribute' => 'question_id',
                'value' => 'question.question_body'
            ],
            'answer_body',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'filter' => AnswerHelper::answerFlagsList(),
                'value' => function ($model) {
                    return AnswerHelper::answerFlagLabel($model->answer_flag);
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
