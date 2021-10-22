<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionnaireCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionnaire-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!--    <?//= $form->field($model, 'status')->textInput() ?> -->

    <?= $form->field($model, 'status')->dropDownList(
        $model->statuses,
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <!--   <?//= $form->field($model, 'created_at')->textInput() ?>  -->

    <!--   <?//= $form->field($model, 'updated_at')->textInput() ?>  -->

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
