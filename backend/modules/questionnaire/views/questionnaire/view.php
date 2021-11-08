<?php

use backend\modules\questionnaire\models\QuestionType;
use common\helpers\StatusHelper;
use common\helpers\TimeHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */
/* @var $questionDataProvider yii\data\ActiveDataProvider */
/* @var $questionSearchModel  backend\modules\questionnaire\models\QuestionSearch */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="questionnaire-view">

    <p>
        <?= Html::a('Список', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту анкету?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => ArrayHelper::getValue($model,'category.title')
            ],
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => StatusHelper::statusLabel($model->status),
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'time_limit',
                'format' => 'raw',
                'value' => TimeHelper::limitTime($model->time_limit),
            ],
        ],
    ]) ?>

    <div>
        <h2>
            <?= 'Вопросы анкеты: '?>
        </h2>
    </div>

    <?= GridView::widget([
        'dataProvider' => $questionDataProvider,
        'filterModel' => $questionSearchModel,
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
                            ['question/update', 'id' => $model['id'], 'questionnaire_id' => $model['questionnaire_id']]);
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            [
                                    'question/delete', 'id' => $model['id'], 'questionnaire_id' => $model['questionnaire_id']
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
                ['question/create', 'questionnaire_id' => $model->id],
                ['class' => 'btn btn-primary']
        ) ?>
    </p>

</div>
