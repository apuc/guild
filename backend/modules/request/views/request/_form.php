<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\request\models\Request */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'position_id')->dropDownList(\common\models\Position::getList(), [
        'prompt' => 'Выберите'
    ]) ?>

    <?= $form->field($model, 'skill_ids')->widget(
        Select2::class,
        [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
            'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    )->label('Навыки'); ?>

    <?= $form->field($model, 'knowledge_level_id')->dropDownList(
        \common\models\UserCard::getLevelList(),
        ['prompt' => '...']
    ) ?>

    <?= $form->field($model, 'descr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'specialist_count')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\Request::getStatus(), [
        'prompt' => 'Выберите'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
