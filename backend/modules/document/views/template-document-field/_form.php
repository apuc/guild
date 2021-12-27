<?php

use backend\modules\document\models\Template;
use common\models\DocumentField;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\TemplateDocumentField */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-document-field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'template_id')->widget(Select2::className(),
        [
            'data' => Template::find()->select(['title', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите шаблон','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => false
            ],
    ]) ?>

    <?= $form->field($model, 'field_id')->widget(Select2::className(),
        [
            'data' => DocumentField::find()->select(['title', 'document_field.id'])
                ->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите поле','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => false,
                'multiple' => true,
                'closeOnSelect' => false
            ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
