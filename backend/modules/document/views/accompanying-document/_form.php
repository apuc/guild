<?php

use backend\modules\document\models\Document;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\AccompanyingDocument */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accompanying-document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document_id')->widget(Select2::className(),
        [
            'data' => Document::find()->select(['title', 'id'])
                ->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите документ','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accompanying_document')->widget(FileInput::classname(), [
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
