<?php

use backend\modules\questionnaire\models\Question;
use backend\modules\questionnaire\models\UserQuestionnaire;
use common\helpers\AnswerHelper;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\UserResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-response-index">

    <p>
        <?= Html::a('Новый ответ пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                'value' => 'user.username',
            ],
            [
                'attribute' => 'question_id',
                'filter' => Question::find()->select(['question_body', 'id'])->indexBy('id')->column(),
                'value' => 'question.question_body',
            ],
            'response_body',
            'created_at',
            'updated_at',
            [
                'attribute' =>'answer_flag',
                'format' => 'raw',
                'filter' => AnswerHelper::answerFlagsList(),
                'value' => function ($model) {
                    return AnswerHelper::userResponseLabel($model->answer_flag);
                },
            ],
            [
                'attribute' => 'user_questionnaire_uuid',
                'filter' => UserQuestionnaire::find()->select(['uuid', 'id'])->indexBy('id')->column(),
                'value' => 'questionnaire.title',
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
