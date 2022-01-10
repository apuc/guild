<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'template')->widget(FileInput::classname(), [
        'options' => ['accept' => 'text/*'],
        'pluginOptions' => [
            'allowedFileExtensions'=>['docx'],'showUpload' => true
        ],
    ]);   ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>