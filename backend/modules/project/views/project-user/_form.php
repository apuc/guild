<?php

use backend\modules\project\models\Project;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->dropDownList(
        Project::find()->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'project-id',
            'prompt' => 'Выберите'
        ]
    );
    ?>

    <?= $form->field($model, 'card_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'card_id'],
            'pluginOptions' => [
                'depends' => ['project-id'],
                'url' => Url::to(['/project/project-user/users-not-on-project'])
                ,'initialize' => false,
            ],

        'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => [
                'pluginOptions' => [
                    'placeholder' => 'Вводите фио',
                    'allowClear' => true,
                    'closeOnSelect' => false,
                    'multiple' => true,
                ],
                'showToggleAll' => true,
            ],
        ]
    );
    echo "<p>
        * в списке отображаются только пользователи у которых присудствует запись в таблице user (в user_card есть id_user)
    </p>";
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
