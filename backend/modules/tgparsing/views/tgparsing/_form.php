<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgparsing\models\Tgparsing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tgparsing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'channel_id')->textInput() ?>

    <?= $form->field($model, 'channel_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ],
    ]); ?>


    <?= $form->field($model, 'status')->dropDownList(\common\models\Tgparsing::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
