<?php

use backend\modules\questionnaire\models\Questionnaire;
use backend\modules\questionnaire\models\UserQuestionnaire;
use common\helpers\AnswerHelper;
use common\models\User;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\UserResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\questionnaire\models\UserResponse */
/* @var $questionnaire backend\modules\questionnaire\models\Questionnaire */

$this->title = 'Ответы пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-responses-index">

    <p>
        <?= Html::a('Создать новый ответ пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_questionnaire_id',
                'filter' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => function($model){
                    return  $model->getQuestionnaireTitle();
                }
            ],
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                'value' => 'user.username',

            ],
            [
                'attribute' => 'question_id',
                'value' => 'question.question_body',
            ],

            'response_body',
            [
                'attribute' => 'Тип вопроса',
                'value' => function($model){
                    return $model->getQuestionType();
                }
            ],
            [
                'attribute' => 'answer_flag',
                'filter' => AnswerHelper::answerFlagsList(),
                'format' => 'raw',
                'value' => function ($model) {
                    return AnswerHelper::answerFlagLable($model->answer_flag);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
