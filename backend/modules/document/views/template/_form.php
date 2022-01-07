<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= InputFile::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        // вставляем название контроллера, по умолчанию равен elfinder
        //'filter' => ['image', 'application/zip',  'application/csv', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
        'name' => 'Template[template_file_name]',
        'id' => 'template-doc',
        'template' => '<label>Шаблон</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
        'options' => ['class' => 'form-control', 'maxlength' => '255'],
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'value' => $model->template_file_name,
        'buttonName' => 'Выбрать шаблон',
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
