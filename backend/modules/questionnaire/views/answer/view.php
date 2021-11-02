<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Answer */

$this->title = cut_title($model->answer_body);
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

function cut_title($str)
{
    if(strlen($str) > 35){
        return mb_substr($str, 0, 35, 'UTF-8') . '...';
    }
    return $str;
}
?>
<div class="answer-view">

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
                'attribute' => 'question_id',
                'value' => function($model){
                    return  $model->getQuestionBody();
                }
            ],
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'filter' => \common\helpers\AnswerHelper::answerFlagsList(),
                'value' => function ($model) {
                    return \common\helpers\AnswerHelper::answerStatusLabel($model->status);
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
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
