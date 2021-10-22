<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'question_type_id') ?>

    <?= $form->field($model, 'questionnaire_id') ?>

    <?= $form->field($model, 'question_body') ?>

    <?= $form->field($model, 'question_priority') ?>

    <?php // echo $form->field($model, 'next_question') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'score') ?>

    <?php // echo $form->field($model, 'time_limit') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
