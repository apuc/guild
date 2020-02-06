<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $now = time();
    $day = idate('d', $now);
    $month = idate('m', $now);
    $year = idate('Y', $now);
    $date = $year."-".$month."-".$day;

    if(!$model->created_at)
        $model->created_at = $date;
    echo '<b>Дата заполнения отчета:</b>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'created_at',
        'options' => [],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]).'<br>';
    ?>

    <?= $form->field($model, 'today')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'difficulties')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'tomorrow')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
