<?php

use backend\modules\questionnaire\models\Question;
use common\helpers\AnswerHelper;
use common\helpers\StatusHelper;
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
        'data' => Question::find()->select(['question_body', 'id'])
            ->where(['!=', 'question_type_id', '1'])
            ->indexBy('id')
            ->column(),
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]) ?>

    <?= $form->field($model, 'answer_body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer_flag')->dropDownList(
        AnswerHelper::answerFlagsList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
