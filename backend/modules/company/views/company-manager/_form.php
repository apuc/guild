<?php

use backend\modules\card\models\UserCard;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\CompanyManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->dropDownList(
        ArrayHelper::map(\backend\modules\company\models\Company::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <?= $form->field($model, 'user_card_id')->dropDownList(
            ArrayHelper::map(UserCard::getCardByUserRole('company_manager'), 'id', 'fio'),
            [
                'prompt' => 'Выберите'
            ]
        )
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
