<?php

use backend\modules\project\models\Project;
use backend\modules\settings\models\Mark;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectMark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-mark-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'project-id',
            'placeholder' => 'Выберите',
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'mark_id')->dropDownList(
        Mark::find()->select(['title', 'id'])
            ->indexBy('id')
            ->column(),
        [
            'placeholder' => 'Выберите',
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
