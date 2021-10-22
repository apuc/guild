<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserQuestionnaire */
/* @var $responseDataProvider yii\data\ActiveDataProvider */

$user = $model->getUserName();
$questionnaire = $model->getQuestionnaireTitle();

$this->title = $user . ": " . $questionnaire;
$this->params['breadcrumbs'][] = ['label' => 'User Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-questionnaire-view">

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
                'attribute' => 'questionnaires_id',
                'value' => $questionnaire,
            ],
            [
                'attribute' => 'user_id',
                'value' => $user,
            ],
            'uuid',
            'score',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag(
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
        ],
    ]) ?>

    <p>

        <?= Html::a('Проверить ответы', ['rate-responses', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Проверка ответов пользователя: ' . $user . ". Категория: " . $questionnaire,
//                'method' => 'post',
            ],
        ]) ?>
        <?php
        Modal::begin([
            'header' => '<h3>Подсчёт балов</h3>',
            'toggleButton' => [
                'label' => 'Посчитать баллы',
                'tag' => 'button',
                'class' => 'btn btn-success',
            ],
        ]);
        if($model->checkAnswerFlagsForNull())
        {
            echo 'Ответы проверены. Посчитать баллы?';
            echo Html::a('Посчитать баллы', ['calculate-score', 'id' => $model->id], [
                'class' => 'btn btn-primary'
            ]);
        }
        else
        {
            echo 'Не все ответы проверены.';
        }

        ?>


    <?php Modal::end(); ?>
    </p>

    <div>
        <h2>
            <?= 'Ответы пользователя' ?>
        </h2>
    </div>

    <?php

        echo GridView::widget([
            'dataProvider' => $responseDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'response_body',
                [
                    'attribute' => 'question_id',
                    'value' => function($model){
                        return $model->getQuestionBody();
                    }
                ],
                [
                    'attribute' => 'Тип вопроса',
                    'value' => function($model){
                        return $model->getQuestionType();
                    }
                ],
                [
                    'attribute' => 'answer_flag',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $answerFlag = $model->answer_flag;

                        $class = 'label label-warning';
                        $content = 'Not verified';

                        if ($answerFlag > 0)
                        {
                            $class = 'label label-success';
                            $answerFlag < 1 ? $content = $answerFlag *100 . '%' : $content = 'True';
                        }
                        else if ($answerFlag === 0.0)
                        {
                            $class = 'label label-danger';
                            $content = 'Wrong';
                        }

                        return Html::tag(
                            'span',
                            $content,
                            [
                                'class' => $class,
                            ]
                        );
                    },
                ],

    //            'created_at',
    //            'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}', // {delete}
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                ['user-response/update', 'id' => $model['id']]);
                        },
                    ],
                ],
            ],

        ]);
    ?>

</div>
