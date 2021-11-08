<?php

use backend\modules\questionnaire\models\Question;
use backend\modules\questionnaire\models\UserQuestionnaire;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserResponse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer_flag')->dropDownList(
        [
            '' => 'Не задано',
            '0.1' => '10%',
            '0.2' => '20%',
            '0.3' => '30%',
            '0.5' => '50%',
            '0.7' => '70%',
            '0.8' => '80%',
            '0.85' => '85%',
            '0.9' => '90%',
            '1' => '100%',
        ]
    ) ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => \common\models\User::find()->select(['username','id'] )->indexBy('id')->column(),
        'options' => ['placeholder' => '...','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],

    ]); ?>

    <?= $form->field($model, 'question_id')->widget(Select2::class,[

        'data' => Question::find()->select(['question_body', 'id'])->indexBy('id')->column(),
        'pluginOptions' => [
            'allowClear' => true // 'id != :id', ['id'=>1]
        ],
    ])?>

    <?= $form->field($model, 'user_questionnaire_id')->widget(Select2::class,[
        'data' => UserQuestionnaire::find()->select(['id', 'id'])->indexBy('id')->column(),
        'options' => ['placeholder' => '...','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <?= $form->field($model, 'response_body')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
