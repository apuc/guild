<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\tgbotmsg\models\TgBotMsg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tg-bot-msg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dialog_id')->widget(
        Select2::class,
        [
            'data' => \frontend\modules\api\services\UserTgBotService::getDialogs(),
            'options' => ['placeholder' => '...', 'class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\TgBotMsg::getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
