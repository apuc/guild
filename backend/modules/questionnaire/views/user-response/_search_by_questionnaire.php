<?php

use backend\modules\questionnaire\models\Questionnaire;
use backend\modules\questionnaire\models\UserQuestionnaire;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="question-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'user_questionnaire_uuid')->widget(Select2::className(),[
//            'data' => Questionnaire::find()->select(['title', 'id'])->indexBy('id')->column(),
            'data' => Questionnaire::find()->joinWith('userQuestionnaires')->select(['title', 'uuid',])->column(),
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
<?php
