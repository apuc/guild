<?php

use asmoday74\ckeditor5\EditorClassic;
use backend\modules\document\models\DocumentField;
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
                <?php
                foreach (DocumentField::getTitleFieldTemplateArr() as $fieldTitle => $fieldTemplate) {
                    echo "
                                <tr class='info'>
                                    <td class='table-cell'>$fieldTitle</td>
                                    <td class='table-cell'>$fieldTemplate</td>
                                </tr>
                             ";
                }
                ?>
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

