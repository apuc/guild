<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $form yii\widgets\ActiveForm */
/* @var $model \backend\modules\settings\models\SkillsOnMainPageForm */

?>
<div class="skill-form">

    <?php if ($model->showMsg): ?>
        <div class="alert alert-success" role="alert">
            Данные сохранены.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'skills_back')->widget(
                Select2::class,
                [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('Навыки Backend'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'skills_front')->widget(
                Select2::class,
                [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('Навыки FrontEnd'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'skills_design')->widget(
                Select2::class,
                [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('Навыки Design'); ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
