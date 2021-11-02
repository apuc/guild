<?php

use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

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

<?php
//$this->registerJs(
//    '$("document").ready(function(){
//            $("#new_note").on("pjax:end", function() {
//            $.pjax.reload({container:"#user_responses"});  //Reload GridView
//        });
//    });'
//);
?>
<div class="user-questionnaire-view">

<!--    --><?php //var_dump($model->setPercentCorrectAnswers(4)); die();?>

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
                'attribute' => 'percent_correct_answers',
                'value' => function($model) {
                    $percent = $model->percent_correct_answers * 100;
                    return $percent . '%';
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    return common\helpers\StatusHelper::statusLabel($model->status);
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

    <?php Pjax::begin(['id' => 'user_responses']); ?>
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
                            return \common\helpers\AnswerHelper::answerFlagLable($model->answer_flag);
                        },

                    ],
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
    <?php Pjax::end(); ?>

</div>
