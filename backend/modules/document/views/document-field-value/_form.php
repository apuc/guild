<?php

use backend\modules\document\models\Document;
use backend\modules\document\models\DocumentField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */
/* @var $form yii\widgets\ActiveForm */
/* @var $fromDocument bool */
?>

<div class="document-field-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        if (!$fromDocument) {
            echo $form->field($model, 'document_field_id')->dropDownList(
                ArrayHelper::map(DocumentField::find()->all(), 'id', 'title'),
                ['prompt' => '...']
            );
            echo $form->field($model, 'document_id')->dropDownList(
                ArrayHelper::map(Document::find()->all(), 'id', 'title'),
                ['prompt' => '...']
            );
        }
    ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
