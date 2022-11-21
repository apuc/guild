<?php

use asmoday74\ckeditor5\EditorClassic;
use backend\modules\card\models\ResumeTemplate;
use common\helpers\StatusHelper;
use mihaildev\elfinder\InputFile;
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

            <?= $form->field($model, 'header_text')->textInput(['maxlength' => true]) ?>

            <div class="imgUpload form-group">
                <div class="media__upload_img">
                    <img src="<?= $model->header_image; ?>" width="100px"/>
                </div>
                <?php echo InputFile::widget([
                        'language' => 'ru',
                        'controller' => 'elfinder',
                        // вставляем название контроллера, по умолчанию равен elfinder
                        'filter' => 'image',
                        // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                        'name' => 'ResumeTemplate[header_image]',
                        'id' => 'resumeTemplateHeader_img',
                        'template' => '<label>Картинка в верхнем контикуле</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
                        'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                        'buttonOptions' => ['class' => 'btn btn-primary'],
                        'value' => $model->header_image,
                        'buttonName' => 'Выбрать изображение',
                    ]);
                ?>
            </div>

            <?= $form->field($model, 'footer_text')->textInput(['maxlength' => true]) ?>

            <div class="imgUpload form-group">
                <div class="media__upload_img">
                    <img src="<?= $model->footer_image; ?>" width="100px"/>
                </div>
                <?php echo InputFile::widget([
                    'language' => 'ru',
                    'controller' => 'elfinder',
                    // вставляем название контроллера, по умолчанию равен elfinder
                    'filter' => 'image',
                    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                    'name' => 'ResumeTemplate[footer_image]',
                    'id' => 'resumeTemplateFooter_img',
                    'template' => '<label>Картинка в верхнем контикуле</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
                    'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                    'buttonOptions' => ['class' => 'btn btn-primary'],
                    'value' => $model->footer_image,
                    'buttonName' => 'Выбрать изображение',
                ]);
                ?>
            </div>

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
                    foreach (ResumeTemplate::$fieldNamesAndSignature as $fieldNames => $signature) {
                        echo "
                                <tr class='info'>
                                    <td class='table-cell'>$fieldNames</td>
                                    <td class='table-cell'>$signature</td>
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


