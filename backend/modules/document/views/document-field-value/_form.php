<?php

use backend\modules\document\models\Document;
use common\models\DocumentField;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-field-value-form">

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

    <?= $form->field($model, 'field_id')->widget(Select2::className(),
        [
            'data' => DocumentField::find()->select(['title', 'id'])
                ->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите поле','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
