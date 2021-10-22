<?php

use backend\modules\questionnaire\models\Questionnaire;
use kartik\depdrop\DepDrop;
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый ответ пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<!--    --><?php //$form = ActiveForm::begin(); ?>

<!--   <?//= $form->field($model, 'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(
//        \common\models\User::find()->all(), 'id', 'username'),
//        [
//            'id'=>'user-id',
//            'prompt' => 'Выберите пользователя'
//        ]
//    ) ?>
 -->

<!--   <?//= $form->field($questionnaire, 'title')->widget(DepDrop::classname(), [
//        'options'=>['id'=>'questionnaire-id'],
//        'pluginOptions'=>[
//            'depends'=>['user-id'],
//            'placeholder'=>'Выберите...',
//            'url' => Url::to(['/questionnaire/user-response/questionnaire'])
//        ]
//    ]);?>
 -->

<!--    --><?php //ActiveForm::end(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            [
                'attribute' => 'user_questionnaire_id',
                'value' => function($model){
                    return  $model->getQuestionnaireTitle();
                }
            ],
//        'user_questionnaire_id',

            [
                'attribute' => 'user_id',
                'value' => function($model){
                    return  $model->getUserName();
                }
            ],
            [
                'attribute' => 'question_id',
                'value' => function($model){
                    return $model->getQuestionBody();
                }
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
