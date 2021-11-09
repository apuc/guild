<?php

use common\helpers\AnswerHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */

$this->title = $model->response_body;
$this->params['breadcrumbs'][] = ['label' => 'User Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-response-view">

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
                'attribute' => 'user_id',
                'value' => ArrayHelper::getValue($model, 'user.username'),
            ],
            [
                'attribute' => 'question_id',
                'value' => ArrayHelper::getValue($model, 'question.question_body'),
            ],
            'response_body',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'value' => AnswerHelper::answerFlagLabel($model->answer_flag),
            ],
            'user_questionnaire_uuid',
        ],
    ]) ?>

</div>
