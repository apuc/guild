<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question_id')->widget(Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Question::find()->where(['!=', 'question_type_id', '1'])->all(), 'id', 'question_body'),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'answer_body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer_flag')->dropDownList(
        \common\helpers\AnswerHelper::answerFlagsList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        \common\helpers\StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
