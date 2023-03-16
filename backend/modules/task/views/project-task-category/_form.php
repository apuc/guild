<?php

use backend\modules\project\models\Project;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTaskCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-task-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'project_id',
            'prompt' => 'Выберите'
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
