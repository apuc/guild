<?php

use common\helpers\AnswerHelper;
use common\helpers\StatusHelper;
use common\helpers\TimeHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Question */
/* @var $answerSearchModel backend\modules\questionnaire\models\Question */
/* @var $answerDataProvider backend\modules\questionnaire\models\Question */

$this->title = $model->question_body;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'question_type_id',
                'value' => ArrayHelper::getValue($model, 'questionType.question_type'),
            ],
            [
                'attribute' => 'questionnaire_id',
                'value' => ArrayHelper::getValue($model,'questionnaire.title'),
            ],
            'question_body',
            'question_priority',
            'next_question',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => StatusHelper::statusLabel($model->status),
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => TimeHelper::limitTime($model->time_limit),
            ],
            'score'
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Ответы: '?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $answerDataProvider,
//        'filterModel' => $answerSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'answer',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['answer/update', 'id' => $model['id'], 'question_id' => $model['question_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'answer/delete', 'id' => $model['id'], 'question_id' => $model['question_id']
                            ],
                            [
                                'data' => ['confirm' => 'Вы уверены, что хотите удалить этот вопрос?', 'method' => 'post']
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a(
            'Добавить новый ответ',
            ['answer/create', 'question_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
