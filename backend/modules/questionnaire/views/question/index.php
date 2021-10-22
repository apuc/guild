<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список вопросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <!--    <h1>-->
    <!--        <?//= Html::encode($this->title) ?>  -->
    <!--    </h1>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вопрос', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'question_body',
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
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'time_limit',
                'value' => function($model){
                    return $model->limitTime;
                }
            ],
            'score',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
