<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\questionnaire\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы на вопросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый ответ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute' => 'question_id',
                'value' => function($model){
                    return  $model->getQuestionBody();
                }
            ],
            'answer_body',
            [
                'attribute' => 'answer_flag',
                'format' => 'raw',
                'value' => function ($model) {
                    return \yii\helpers\Html::tag(
                        'span',
                        $model->answer_flag ? 'Correct' : 'Wrong',
                        [
                            'class' => 'label label-' . ($model->answer_flag ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
