<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'password-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'   => false,
    'method' => 'post',
]); ?>

<h4>Введите новый пароль</h4>

<?= Html::input('text', 'password', '', ['class' => 'form-control custom-input']) ?>

<br>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
