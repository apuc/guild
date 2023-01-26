<?php

use backend\modules\project\models\Project;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
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

    <?= $form->field($model, 'mark_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'mark_id'],
            'pluginOptions' => [
                'depends' => ['project-id'],
                'url' => Url::to(['/project/project-mark/users-not-on-project'])
                ,'initialize' => false,
            ],

            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => [
                'hideSearch' => false,
                'pluginOptions' => [
                    'placeholder' => 'Вводите название метки',
                    'allowClear' => true,
                    'closeOnSelect' => false,
                    'multiple' => true,
                    'hideSearch' => false
                ],
                'showToggleAll' => true,
            ],
        ]
    );
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
