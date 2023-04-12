<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\request\models\RequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'position_id') ?>

    <?php // echo $form->field($model, 'skill_ids') ?>

    <?php // echo $form->field($model, 'knowledge_level_id') ?>

    <?php // echo $form->field($model, 'descr') ?>

    <?php // echo $form->field($model, 'specialist_count') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
