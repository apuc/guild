<?php

use common\helpers\AnswerHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */
/* @var $responseDataProvider yii\data\ActiveDataProvider */

$this->title =cut_title($model->response_body);
$this->params['breadcrumbs'][] = ['label' => 'User Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

function cut_title($str)
{
    if(strlen($str) > 40){
        return mb_substr($str, 0, 40, 'UTF-8') . '...';
    }
    return $str;
}
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
                'attribute' => 'Пользователь',
                'value' => ArrayHelper::getValue($model,'user.username'),
            ],
            [
                'attribute' => 'Вопрос',
                'value' => ArrayHelper::getValue($model,'question.question_body'),
            ],
            'response_body',
            'created_at',
            'updated_at',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'value' => AnswerHelper::answerFlagLable($model->answer_flag),
            ],
            'user_questionnaires_uuid',
        ],
    ]) ?>

</div>
