<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\hh\models\HhJob */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hh-job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_id')->textInput() ?>

    <?= $form->field($model, 'hh_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary_from')->textInput() ?>

    <?= $form->field($model, 'salary_to')->textInput() ?>

    <?= $form->field($model, 'salary_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dt_add')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
