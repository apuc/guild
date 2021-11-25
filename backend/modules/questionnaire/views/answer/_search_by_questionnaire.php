<?php

use backend\modules\questionnaire\models\Questionnaire;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelSearch backend\modules\questionnaire\models\AnswerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($modelSearch, 'questionnaire')->widget(Select2::className(),[
        'data' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
        'options' => ['placeholder' => 'Выберите анкету'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Анкета') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
