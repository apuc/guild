<?php

use backend\modules\document\models\Document;
use common\models\DocumentField;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $documentFieldValues backend\modules\document\models\DocumentFieldValue[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-field-value-form">

    <h2>
        Заполнение полей документа: <?php echo(ArrayHelper::getValue($documentFieldValues[0], 'document.title'));  ?>
    </h2>

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($documentFieldValues as $index => $documentFieldValue) { ?>

        <?= $form->field($documentFieldValue, "[$index]value")
            ->textInput(['maxlength' => true])
            ->label(ArrayHelper::getValue($documentFieldValue,'field.title')
        ) ?>

    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
