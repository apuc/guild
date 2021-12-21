<?php

use asmoday74\ckeditor5\EditorClassic;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model */

$this->title = 'Резюме';
?>
<div class="user-card-view">
    <h1>Резюме</h1>

    <?php $form = ActiveForm::begin(['action' => Url::base(true)]); ?>
    <?= $form->field($model, 'vc_text')->widget(EditorClassic::className(), [
        'clientOptions' => [
            'language' => 'ru',
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fas fa-long-arrow-alt-left"></i> Back', Url::base(true), ['class' => 'btn btn-primary', 'style' => 'float: right']) ?>
    </div>
    <?php $form = ActiveForm::end(); ?>
</div>