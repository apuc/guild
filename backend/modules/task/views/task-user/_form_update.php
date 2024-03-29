<?php

use backend\modules\task\models\ProjectTask;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTaskUser */
/* @var $form yii\widgets\ActiveForm */
/* @var $task_id  */
?>

<div class="task-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->widget(Select2::className(),[
        'data' => ProjectTask::find()->select(['title', 'id'])->indexBy('id')->column(),
        'options' => ['placeholder' => 'Выберите проект', 'value' => $task_id, 'id' => 'task-id',],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);
    ?>

    <?= $form->field($model, 'project_user_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'project-user-id', 'allowClear' => true],
            'pluginOptions' => [
                'depends' => ['task-id'],
                'placeholder' => 'Выберите',
                'initialize' => true,
                'url' => Url::to(['/task/task-user/executor']),
            ]
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Назначить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
