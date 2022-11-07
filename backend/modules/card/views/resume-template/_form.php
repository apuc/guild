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
                        <td>ФИО</td>
                        <td class="table-cell">${fio}</td>
                    </tr>
                    <tr class="info">
                        <td>Паспорт</td>
                        <td class="table-cell">${passport}</td>
                    </tr>
                    <tr class="info">
                        <td>Электронная почта</td>
                        <td class="table-cell">${email}</td>
                    </tr>
                    <tr class="info">
                        <td>Пол</td>
                        <td class="table-cell">${gender}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме</td>
                        <td class="table-cell">${resume}</td>
                    </tr>
                    <tr class="info">
                        <td>Зароботная плата</td>
                        <td class="table-cell">${salary}</td>
                    </tr>
                    <tr class="info">
                        <td>Позиция</td>
                        <td class="table-cell">${position_id}</td>
                    </tr>
                    <tr class="info">
                        <td>Город</td>
                        <td class="table-cell">${city}</td>
                    </tr>
                    <tr class="info">
                        <td>Ссылка ВК</td>
                        <td class="table-cell">${link_vk}</td>
                    </tr>
                    <tr class="info">
                        <td>Ссылка Телграм</td>
                        <td class="table-cell">${link_telegram}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме текст</td>
                        <td class="table-cell">${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td>Уровень</td>
                        <td class="table-cell">${level}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме текст</td>
                        <td class="table-cell">${vc_text}</td>
                    </tr>
                    <tr class="info">
                        <td>Резюме короткий текст</td>
                        <td class="table-cell">${vc_text_short}</td>
                    </tr>
                    <tr class="info">
                        <td>Лет опыта</td>
                        <td class="table-cell">${years_of_exp}</td>
                    </tr>
                    <tr class="info">
                        <td>Спецификация</td>
                        <td class="table-cell">${specification}</td>
                    </tr>
                    <tr class="info">
                        <td>Навыки</td>
                        <td class="table-cell">${skills}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--<script>-->
<!--    document.querySelectorAll(".table-cell").forEach(function(elm){-->
<!--        elm.addEventListener("mouseover", function(e){-->
<!--            e.target.style.backgroundColor = '#76d7c4';-->
<!--            var copyText = e.target.textContent;-->
<!--            const el = document.createElement('textarea');-->
<!--            el.value = copyText;-->
<!--            document.body.appendChild(el);-->
<!--            el.select();-->
<!--            document.execCommand('copy');-->
<!--            document.body.removeChild(el);-->
<!---->
<!--            /* Alert the copied text */-->
<!--            alert("Copied the text: " + el.value);-->
<!--        });-->
<!--    })-->
<!--</script>-->


