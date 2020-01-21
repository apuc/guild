<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Skill;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\card\models\UserCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList($model->genders, ['prompt' => 'Выберите']) ?>

    <?= $form->field($model, 'dob')->input(
        'date',
        [
            'placeholder' => 'Zadejte svůj Datum narození',
            'language' => 'en',
            "data-format" => "DD MMMM YYYY",

        ]
    ) ?>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'skill')->widget(
                Select2::class,
                [
                    'data' => ArrayHelper::map(Skill::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('Навыки'); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>