<?php

use backend\modules\questionnaire\models\Question;
use common\helpers\AnswerHelper;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(),
        [
            'data' => User::find()->select(['username', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите пользователя','class' => 'form-control'],
            'pluginOptions' => [
                'placeholder' => 'Выберите',
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'question_id')->widget(Select2::className(),
        [
            'data' => Question::find()->select(['question_body', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите пользователя','class' => 'form-control'],
            'pluginOptions' => [
                'placeholder' => 'Выберите',
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'response_body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer_flag')->dropDownList(
        AnswerHelper::answerFlagsList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'user_questionnaire_uuid')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
