<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Question */

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
                'confirm' => 'Are you sure you want to delete this item?',
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
            'question_body',
            'question_priority',
            'next_question',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\Html::tag(
                        'span',
                        $model->status ? 'Active' : 'Not Active',
                        [
                            'class' => 'label label-' . ($model->status ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return $model->limitTime;
                }
            ],
            'score'
        ],
    ]) ?>

</div>
