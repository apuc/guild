<?php

use mihaildev\elfinder\InputFile;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model common\models\Accesses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accesses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access')->textarea(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-xs-12">
            <?= Select2::widget(
                [
                    'model' => $model,
                    'attribute' => '_projects',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Project::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <text>Пользователи</text>
            <?= Select2::widget(
                [
                    'model'=> $model,
                    'attribute' => '_users',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\UserCard::find()->all(), 'id', 'fio'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            ) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
