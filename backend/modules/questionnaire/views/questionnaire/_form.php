<?php

use backend\components\timepicker\src\TimePicker;
use common\helpers\StatusHelper;
use backend\modules\questionnaire\models\QuestionnaireCategory;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\Questionnaire */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionnaire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->widget(Select2::class,
        [
            'data' => QuestionnaireCategory::find()->select(['title', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
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

    <?= $form->field($model, 'time_limit')->widget(TimePicker::class,
        [
            'name' => 'time_limit_picker',
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
                'defaultTime' => ''
            ]
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
