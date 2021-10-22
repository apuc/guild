<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
