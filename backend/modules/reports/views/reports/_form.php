<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_at')->input(
        'date',
        [
            'placeholder' => 'Zadejte svůj Datum narození',
            'language' => 'en',
            "data-format" => "DD MMMM YYYY",
            'class' => 'form-control report-date'

        ]
    ) ?>

    <?= $form->field($model, 'today')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'difficulties')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'tomorrow')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_card_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(common\models\UserCard::find()->all(), 'id', 'fio'),
        ['prompt' => '...']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
