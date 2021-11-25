<?php

use backend\modules\task\models\Task;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\TaskUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'task_id')->dropDownList(Task::find()
        ->select(['title', 'id'])->indexBy('id')->column(),
        [
            'id' => 'task-id',
            'prompt' => 'Выберите'
        ]
    );
    ?>

    <?= $form->field($model, 'project_user_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'project-user-id'],
            'pluginOptions' => [
                'depends' => ['task-id'],
                'placeholder' => 'Выберите',
                'url' => Url::to(['/task/task-user/executor'])
            ]
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
