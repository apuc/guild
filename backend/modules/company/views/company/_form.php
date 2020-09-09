<?php

use backend\modules\settings\models\AdditionalFields;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(
            \common\models\Status::find()
                ->joinWith('useStatuses')
                ->where(['`use_status`.`use`' => \common\models\UseStatus::USE_COMPANY])->all(), 'id', 'name'),
            [
                'prompt' => 'Выберите'
            ]
        ) ?>


    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'fields')->widget(MultipleInput::class,[
                'cloneButton' => true,
                'columns' => [
                    [
                        'name' => 'field_id',
                        'type' => 'dropDownList',
                        'title' => 'Поле',
                        'defaultValue' => null,
                        'items' => \yii\helpers\ArrayHelper::map(AdditionalFields::find()
                            ->joinWith('useFields')
                            ->where(['`use_field`.`use`' => \common\models\UseStatus::USE_COMPANY])
                            ->all(),
                            'id', 'name'),
                        'options' => ['prompt' => 'Выберите']
                    ],
                    [
                        'name' => 'value',
                        'title' => 'Значение',
                        'enableError' => true,
                        'type' => InputFile::class,
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
                        'name' => 'order',
                        'title' => 'Приоритет',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
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
