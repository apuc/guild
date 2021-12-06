<?php

use backend\modules\task\models\Task;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\TaskUser */
/* @var $form yii\widgets\ActiveForm */
/* @var $task_id  */
?>

<div class="task-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->widget(Select2::className(),[
        'data' => Task::find()->select(['title', 'id'])->indexBy('id')->column(),
        'options' => ['placeholder' => 'Выберите проект', 'value' => $task_id, 'id' => 'task-id',],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'project_user_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'project-user-id'],
            'pluginOptions' => [
                'depends' => ['task-id'],
                'placeholder' => 'Выберите',
                'initialize' => true,
                'url' => Url::to(['/task/task-user/executor'])
            ]
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Назначить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
