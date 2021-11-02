<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'filter'  => \yii\helpers\ArrayHelper::map(\common\models\Question::find()->where(['!=', 'question_type_id', '1'])->all(), 'id', 'question_body'),
                'attribute' => 'question_id',
                'value' => function($model){
                    return  $model->getQuestionBody();
                }
            ],
            'answer_body',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'filter' => \common\helpers\AnswerHelper::answerFlagsList(),
                'value' => function ($model) {
                    return \common\helpers\AnswerHelper::answerStatusLabel($model->answer_flag);
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => \common\helpers\StatusHelper::statusList(),
                'value' => function($model){
                    return \common\helpers\StatusHelper::statusLabel($model->status);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
