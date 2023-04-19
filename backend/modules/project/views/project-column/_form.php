<?php

use common\models\Project;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectColumn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-column-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'project-id',
            'placeholder' => 'Выберите',
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\ProjectColumn::getStatus(), ['prompt' => 'Выберите статус']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
