<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\access\models\AccessSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accesses-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'project') ?>

    <?php // echo $form->field($model, 'info') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
