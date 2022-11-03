<?php

use asmoday74\ckeditor5\EditorClassic;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\ResumeTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-8">
        <div class="resume-template-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList(
                StatusHelper::statusList(),
                [
                    'prompt' => 'Выберите'
                ]
            ) ?>

            <?= $form->field($model, 'template_body')->widget(EditorClassic::className(), [
                'clientOptions' => [
                    'language' => 'ru',
                ]
            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Поле</th>
                        <th>Сигнатура поля</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="info">
                        <td>ФИО</td>
                        <td>${fio}</td>
                    </tr>
                    <tr class="info">
                        <td>Паспорт</td>
                        <td>${passport}</td>
                    </tr>
                    <tr class="info">
                        <td>Электронная почта</td>
                        <td>${email}</td>
                    </tr>
                    <tr class="info">
                        <td>Пол</td>
                        <td>${gender}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме</td>
                        <td>${resume}</td>
                    </tr>
                    <tr class="info">
                        <td>Зароботная плата</td>
                        <td>${salary}</td>
                    </tr>
                    <tr class="info">
                        <td>Позиция</td>
                        <td>${position_id}</td>
                    </tr>
                    <tr class="info">
                        <td>Город</td>
                        <td>${city}</td>
                    </tr>
                    <tr class="info">
                        <td>Ссылка ВК</td>
                        <td>${link_vk}</td>
                    </tr>
                    <tr class="info">
                        <td>Ссылка Телграм</td>
                        <td>${link_telegram}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме текст</td>
                        <td>${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td>Уровень</td>
                        <td>${level}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме текст</td>
                        <td>${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме короткий текст</td>
                        <td>${vc_text_short}</td>
                    </tr>
                    <tr class="info">
                        <td>Лет опыта</td>
                        <td>${years_of_exp}/td>
                    </tr>
                    <tr class="info">
                        <td>Спецификация</td>
                        <td>${specification}</td>
                    </tr>
                    <tr class="info">
                        <td>Навыки</td>
                        <td>${skills}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


