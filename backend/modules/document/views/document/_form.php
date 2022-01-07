<?php

use backend\modules\document\models\Template;
use backend\modules\employee\models\Manager;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_id')->widget(Select2::className(),
        [
            'data' => Manager::find()->select(['user_card.fio', 'manager.id'])
                ->joinWith('userCard')
                ->indexBy('manager.id')->column(),
            'options' => ['placeholder' => 'Выберите менеджера','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template_id')->widget(Select2::className(),
        [
            'data' => Template::find()->select(['title', 'id'])
                ->indexBy('id')->column(),
            'options' => ['placeholder' => 'Выберите шаблон','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
