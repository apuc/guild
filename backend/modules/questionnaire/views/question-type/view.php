<?php

use backend\modules\questionnaire\models\QuestionType;
use common\helpers\StatusHelper;
use common\helpers\TimeHelper;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionType */
/* @var $questionDataProvider yii\data\ActiveDataProvider */
/* @var $questionSearchModel  backend\modules\questionnaire\models\QuestionSearch */

$this->title = $model->question_type;
$this->params['breadcrumbs'][] = ['label' => 'Question Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-type-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question_type',
            'slug',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $questionDataProvider,
//        'filterModel' => $questionSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_body',
            [
                'attribute' => 'question_type_id',
                'filter' => QuestionType::find()->select(['question_type', 'id'])->indexBy('id')->column(),
                'value' => 'questionType.question_type'
            ],
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'question',
                'buttons' => [

                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['question/update', 'id' => $model['id'], 'question_type_id' => $model['question_type_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                'question/delete', 'id' => $model['id'], 'question_type_id' => $model['question_type_id']
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
            'Добавить новый вопрос',
            ['question/create', 'question_type_id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
