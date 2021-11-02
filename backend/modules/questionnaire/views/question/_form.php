<?php

use kartik\select2\Select2;
use kartik\time\TimePicker;
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

    <?= $form->field($model, 'question_body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'question_priority')->textInput() ?>

    <?= $form->field($model, 'next_question')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(
        \common\helpers\StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'time_limit')->widget(TimePicker::class,
        [
            'name' => 'time_limit_picker',
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
                'defaultTime' => ''
            ]
        ]) ?>

    <?= $form->field($model, 'score')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
