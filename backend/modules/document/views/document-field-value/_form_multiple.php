<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $documentFieldValues backend\modules\document\models\DocumentFieldValue[] */
/* @var $form yii\widgets\ActiveForm */

$model = $documentFieldValues[0];
$this->title = 'Заполнение полей документа: ' . $model->document->title;
$this->params['breadcrumbs'][] = ['label' => 'Значения полей документа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->document->title;
?>

<div class="document-field-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($documentFieldValues as $index => $documentFieldValue) { ?>

        <?= $form->field($documentFieldValue, "[$index]value")
            ->textInput(['maxlength' => true])
            ->label(ArrayHelper::getValue($documentFieldValue,'documentField.title')
            ) ?>

    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>