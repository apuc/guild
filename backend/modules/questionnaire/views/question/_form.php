<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question_type_id')->widget(Select2::class,
        [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\QuestionType::find()->all(),'id', 'question_type'),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'questionnaire_id')->widget(Select2::class,
        [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\Questionnaire::find()->all(),'id', 'title'),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <!--    <?//= $form->field($model, 'question_type_id')->textInput() ?>  -->

    <!--    <?//= $form->field($model, 'questionnaire_id')->textInput() ?>  -->

    <?= $form->field($model, 'question_body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'question_priority')->textInput() ?>

    <?= $form->field($model, 'next_question')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(
        $model->statuses,
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <!--    <?//= $form->field($model, 'created_at')->textInput() ?>  -->

    <!--    <?//= $form->field($model, 'updated_at')->textInput() ?>  -->

    <?= $form->field($model, 'time_limit')->dropDownList(
        [
            '' => 'Не ограничено',
            '30' => '30 секунд',
            '60' => '1 минута',
            '90' => '1:30 секунд',
            '120' => '2 минуты',
            '180' => '3 минуты',
            '300' => '5 минут',
            '600' => '10 минут',
        ]
    ) ?>

    <?= $form->field($model, 'score')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
