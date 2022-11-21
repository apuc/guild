<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\ResumeTemplateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resume-template-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'template_body') ?>

    <?php // echo $form->field($model, 'header_text') ?>

    <?php // echo $form->field($model, 'header_image') ?>

    <?php // echo $form->field($model, 'footer_text') ?>

    <?php // echo $form->field($model, 'footer_image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
