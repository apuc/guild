<?php

use backend\modules\card\models\UserCard;
use backend\modules\project\models\Project;
use common\helpers\StatusHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTask */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->dropDownList(Project::find()
        ->select(['name', 'id'])->indexBy('id')->column(),
        [
            'prompt' => 'Выберите'
        ]
    );
    ?>

    <?= $form->field($model, 'user_id')->widget(
        Select2::class,
        [
            'data' => \common\models\UserCard::getListUserWithUserId(),
            'options' => ['placeholder' => '...', 'class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'column_id')->widget(Select2::class,
        [
            'data' => \common\models\ProjectColumn::find()->select(['title', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true,
                'prompt' => 'Выберите'
            ],
        ]
    ); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'priority')->input('number') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
