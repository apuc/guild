<?php

use backend\modules\employee\models\Manager;
use common\models\User;
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
            'data' => Manager::find()->select(['username', 'manager.id'])
                ->joinWith('user')->indexBy('manager.id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'employee_id')->widget(Select2::className(),
        [
            'data' => User::find()->select(['username', 'user.id'])
                ->joinWith('manager')->where(['manager.user_id' => null])->indexBy('user.id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
