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
            <table class="table" id="fieldNameTable">
                <thead>
                    <tr>
                        <th>Поле</th>
                        <th>Сигнатура поля</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="info">
                        <td class="table-cell">ФИО</td>
                        <td class="table-cell">${fio}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Паспорт</td>
                        <td class="table-cell">${passport}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Электронная почта</td>
                        <td class="table-cell">${email}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Пол</td>
                        <td class="table-cell">${gender}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Резюме</td>
                        <td class="table-cell">${resume}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Зароботная плата</td>
                        <td class="table-cell">${salary}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Позиция</td>
                        <td class="table-cell">${position_id}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Город</td>
                        <td class="table-cell">${city}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Ссылка ВК</td>
                        <td class="table-cell">${link_vk}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Ссылка Телграм</td>
                        <td class="table-cell">${link_telegram}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Резюме текст</td>
                        <td class="table-cell">${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Уровень</td>
                        <td class="table-cell">${level}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Резюме текст</td>
                        <td class="table-cell">${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Резюме короткий текст</td>
                        <td class="table-cell">${vc_text_short}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Лет опыта</td>
                        <td class="table-cell">${years_of_exp}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Спецификация</td>
                        <td class="table-cell">${specification}</td>
                    </tr>
                    <tr class="info">
                        <td class="table-cell">Навыки</td>
                        <td class="table-cell">${skills}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <p>
                Нажмите на ячейку чтобы скопировать содержимое
            </p>
        </div>
    </div>
</div>

<script>
    const popup = document.createElement('h4')
    popup.textContent = 'Скопировано'
    popup.style.cssText = `
      background: #a6caf0;
      position: absolute;
      right: 0;
      top: 0;
      `
    document.querySelectorAll('.table-cell').forEach(function (elm) {
        elm.style.position = 'relative'
        elm.addEventListener('click', function (e) {
            e.target.style.backgroundColor = '#76d7c4'
            var copyText = e.target.textContent
            const el = document.createElement('textarea')
            el.value = copyText
            document.body.appendChild(el)
            el.select()
            document.execCommand('copy')
            document.body.removeChild(el)
            elm.appendChild(popup)
            setTimeout(() => {
                elm.removeChild(popup)
            }, 1000)
        })
    })
</script>


