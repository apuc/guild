<?php

use asmoday74\ckeditor5\EditorClassic;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-8">
        <div class="document-template-form">

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

<!--             composer require --prefer-dist stkevich/yii2-ckeditor5 "*"-->
<!--            --><?//= $form->field($model, 'text')->widget(CKEditor::className(),[
//                'editorOptions' => [ TODO
//                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
//                    'inline' => false, //по умолчанию false
//                ],
//            ]); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
<!--    ['Акт', $time],-->
<!--    ['Акт сверки', $time],-->
<!--    ['Детализация', $time],-->
<!--    ['Доверенность', $time],-->
<!--    ['Договор', $time],-->
<!--    ['Доп соглашение к договору', $time],-->
<!--    ['Транспортная накладная', $time],-->
<!--    ['Ценовой лист', $time],-->
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
                    <td class="table-cell">№ договора</td>
                    <td class="table-cell">${contract_number}</td>
                </tr>
                <tr class="info">
                    <td class="table-cell">Название</td>
                    <td class="table-cell">${title}</td>
                </tr>
                <tr class="info">
                    <td class="table-cell">Компания</td>
                    <td class="table-cell">${company}</td>
                </tr>
                <tr class="info">
                    <td class="table-cell">Представитель</td>
                    <td class="table-cell">${manager}</td>
                </tr>
                <tr class="info">
                    <td class="table-cell">Компания контрагент</td>
                    <td class="table-cell">${contractor_company}</td>
                </tr>
                <tr class="info">
                    <td class="table-cell">Представитель контрагента</td>
                    <td class="table-cell">${contractor_manager}</td>
                </tr>
<!--                <tr class="info">-->
<!--                    <td class="table-cell"></td>-->
<!--                    <td class="table-cell"></td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">№ документа</td>-->
<!--                    <td class="table-cell">${document_number}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">от </td>-->
<!--                    <td class="table-cell">${from}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">сумма с НДС</td>-->
<!--                    <td class="table-cell">${sum_with_NDS}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">НДС</td>-->
<!--                    <td class="table-cell">${NDS}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">цена</td>-->
<!--                    <td class="table-cell">${price}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">к договору</td>-->
<!--                    <td class="table-cell">${to_the_contract}</td>-->
<!--                </tr>-->
<!--                <tr class="info">-->
<!--                    <td class="table-cell">№</td>-->
<!--                    <td class="table-cell">${number}</td>-->
<!--                </tr>-->

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

