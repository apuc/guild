<?php

use backend\modules\card\models\UserCard;
use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectRole;
use backend\modules\project\models\ProjectUser;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->widget(Select2::className(),
        [
            'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>

    <?= $form->field($model, 'card_id')->widget(Select2::className(),
        [
            'data' => UserCard::find()->select(['fio', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => false,
            ],
        ]
    ) ?>

    <?= $form->field($model, 'project_role_id')->widget(Select2::className(),
        [
            'data' => ProjectRole::find()->select(['title', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => false,
            ],
        ]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(ProjectUser::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
