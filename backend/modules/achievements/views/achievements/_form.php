<?php

use backend\modules\settings\models\AdditionalFields;
use mihaildev\elfinder\InputFile;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\achievements\models\Achievement */
/* @var $form yii\widgets\ActiveForm */
/* @var $statuses array */
?>

<div class="notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\Achievement::getStatusLabel()) ?>
    <div class="imgUpload form-group">
        <div class="media__upload_img"><img src="<?= $model->img; ?>" width="100px"/></div>
        <?php
        echo InputFile::widget([
            'language' => 'ru',
            'controller' => 'elfinder',
            // вставляем название контроллера, по умолчанию равен elfinder
            'filter' => 'image',
            // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
            'name' => 'Achievement[img]',
            'id' => 'achievement-img',
            'template' => '<label>Изображение</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
            'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
            'buttonOptions' => ['class' => 'btn btn-primary'],
            'value' => $model->img,
            'buttonName' => 'Выбрать изображение',
        ]);
        ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
