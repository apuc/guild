<?php

use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectUser;
use common\helpers\StatusHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->dropDownList(Project::find()
        ->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'project-id',
            'prompt' => 'Выберите'
        ]
    );
    ?>

    <?= $form->field($model, 'project_user_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'project-user-id'],
            'pluginOptions' => [
                'depends' => ['project-id'],
                'placeholder' => 'Выберите',
                'url' => Url::to(['/task/task/creator'])
            ]
        ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
