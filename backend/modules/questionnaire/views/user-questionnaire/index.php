<?php

use common\helpers\StatusHelper;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\questionnaire\models\Questionnaire;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\UserQuestionnaireSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анкеты пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-questionnaire-index">

    <p>
        <?= Html::a('Назначить анкету пользователю', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'questionnaire_id',
                'filter' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'questionnaire.title'
            ],
            [
                'attribute' => 'user_id',
                'filter' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
                'value' => 'user.username'
            ],
            'score',
            [
                'attribute' => 'percent_correct_answers',
                'value' => function($model) {
                    $percent = $model->percent_correct_answers * 100;
                    return $percent . '%';
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => StatusHelper::statusList(),
                'value' => function ($model) {
                    return StatusHelper::statusLabel($model->status);
                },
            ],
            'created_at',
            'updated_at',
            'testing_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
