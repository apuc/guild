<?php

use backend\modules\settings\models\AdditionalFields;
use mihaildev\elfinder\InputFile;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\notes\models\Note */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'fields')->widget(MultipleInput::class, [

                'columns' => [
                    [
                        'name'  => 'field_id',
                        'type'  => 'dropDownList',
                        'title' => 'Поле',
                        'defaultValue' => null,
                        'items' => \yii\helpers\ArrayHelper::map(AdditionalFields::find()
                            ->joinWith('useFields')
                            ->where(['`use_field`.`use`' => \common\models\UseStatus::USE_NOTE])
                            ->all(),
                            'id', 'name'),
                        'options' => ['prompt' => 'Выберите']
                    ],
                    [
                        'name' => 'value',
                        'title' => 'Значение',
                        'type' => InputFile::className(),
                        'options' => [
                            'language' => 'ru',
                            'controller' => 'elfinder',
                            // вставляем название контроллера, по умолчанию равен elfinder
                            // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                            'name' => 'fields[value]',
                            'id' => 'fields-value',
                            'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                            'buttonOptions' => ['class' => 'btn btn-primary'],
                            'value' => $model->fields[0]['value'],
                            'buttonName' => 'Выбрать файл',
                        ],
                    ],
                    [
                        'name'  => 'order',
                        'title' => 'Приоритет',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ]
                ]
            ])->label('Дополнительно');
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
