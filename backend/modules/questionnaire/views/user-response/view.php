<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */
/* @var $responseDataProvider yii\data\ActiveDataProvider */

$this->title =cut_title($model->response_body);
$this->params['breadcrumbs'][] = ['label' => 'User Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

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
                'value' => function($model){
                    return  $model->getUserName();
                }
            ],
            [
                'attribute' => 'Вопрос',
                'value' => function($model){
                    return $model->getQuestionBody();
                }
            ],
            'response_body',
            'created_at',
            'updated_at',
            'answer_flag',
            'user_questionnaires_uuid',
        ],
    ]) ?>

</div>
