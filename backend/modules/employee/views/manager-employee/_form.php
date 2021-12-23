<?php

use backend\modules\card\models\UserCard;
use backend\modules\employee\models\Manager;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\ManagerEmployee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manager-employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manager_id')->widget(Select2::className(),
        [
            'data' => Manager::find()->select(['fio', 'manager.id'])
                ->joinWith('userCard')->indexBy('manager.id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'user_card_id')->widget(Select2::className(),
        [
            'data' => UserCard::find()->select(['fio', 'user_card.id'])
                ->joinWith('manager')->where(['manager.user_card_id' => null])->indexBy('user_card.id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
            ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
