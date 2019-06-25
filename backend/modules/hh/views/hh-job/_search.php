<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\hh\models\HhJobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hh-job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employer_id') ?>

    <?= $form->field($model, 'hh_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'salary_from') ?>

    <?php // echo $form->field($model, 'salary_to') ?>

    <?php // echo $form->field($model, 'salary_currency') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'dt_add') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
