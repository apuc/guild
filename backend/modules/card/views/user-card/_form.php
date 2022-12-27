<?php

use asmoday74\ckeditor5\EditorClassic;
use common\classes\Debug;
use common\models\Achievement;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-card-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'passport')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row" style="padding-bottom: 15px">
        <div class="imgUpload col-xs-6">
            <div class="media__upload_img"><img src="<?= $model->photo; ?>" width="100px"/></div>
            <?php
            echo InputFile::widget([
                'language' => 'ru',
                'controller' => 'elfinder',
                // вставляем название контроллера, по умолчанию равен elfinder
                'filter' => 'image',
                // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                'name' => 'UserCard[photo]',
                'id' => 'usercard-photo',
                'template' => '<label>Аватар</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
                'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                'buttonOptions' => ['class' => 'btn btn-primary'],
                'value' => $model->photo,
                'buttonName' => 'Выбрать изображение',
            ]);
            ?>
        </div>
        <div class="col-xs-6">
            <?php
            echo InputFile::widget([
                'language' => 'ru',
                'controller' => 'elfinder',
                // вставляем название контроллера, по умолчанию равен elfinder
                //'filter' => ['image', 'application/zip',  'application/csv', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-con..
                'name' => 'UserCard[resume]',
                'id' => 'usercard-resume',
                'template' => '<label>Резюме</label><div class="input-group">{input}<span class="span-btn">{button}</span></div>',
                'options' => ['class' => 'form-control itemImg', 'maxlength' => '255'],
                'buttonOptions' => ['class' => 'btn btn-primary'],
                'value' => $model->resume,
                'buttonName' => 'Выбрать резюме',
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, 'link_vk')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-3">
            <?= $form->field($model, 'link_telegram')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-xs-6">
            <?= $form->field($model, 'gender')->dropDownList(
                $model->genders,
                [
                    'prompt' => 'Выберите'
                ]
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'dob')->input(
                'date',
                [
                    'placeholder' => 'Zadejte svůj Datum narození',
                    'language' => 'en',
                    "data-format" => "DD MMMM YYYY",

                ]
            ) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'status')
                ->dropDownList(
                    \common\models\Status::getStatusesArray(\common\models\UseStatus::USE_PROFILE),
                    [
                        'prompt' => 'Выберите'
                    ]
                ) ?>
        </div>
    </div>

    <div class="row">
        <?php if (Yii::$app->user->can('confidential_information')): ?>
            <div class="col-xs-6">
                <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'resume_tariff')->textInput(['maxlength' => true]) ?>
            </div>
        <?php endif; ?>
        <div class="col-xs-6">
            <?= $form->field($model, 'position_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(\backend\modules\settings\models\Position::find()->all(), 'id', 'name'),
                ['prompt' => '...']
            ) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'level')->dropDownList(
                \common\models\UserCard::getLevelList(),
                ['prompt' => '...']
            ) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'specification')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'years_of_exp')->input('number') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'at_project')->dropDownList(
                $model->getBusyness(),
                [
                    'prompt' => 'Выберите'
                ]
            ) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'skill')->widget(
                Select2::class,
                [
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            )->label('Навыки'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'vc_text_short')->textarea() ?>
        </div>
    </div>

    <?= $form->field($model, 'vc_text')->widget(EditorClassic::className(), [
        'clientOptions' => [
            'language' => 'ru',
        ]
    ]); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($model, 'test_task_getting_date')->input(
                'date',
                [
                    'language' => 'en',
                    "data-format" => "DD MMMM YYYY",
                ]
            ) ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'test_task_complete_date')->input(
                'date',
                [
                    'language' => 'en',
                    "data-format" => "DD MMMM YYYY",
                ]
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'achievements')->widget(Select2::class,
                [
                    'data' => \yii\helpers\ArrayHelper::map(Achievement::find()->where(['status' => Achievement::STATUS_ACTIVE])->all(),'id', 'title'),
                    'options' => ['placeholder' => '...','class' => 'form-control', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'portfolioProjects')->widget(MultipleInput::class, [
                'cloneButton' => true,
                'columns' => [
                    [
                        'name' => 'title',
                        'type' => 'textInput',
                        'title' => 'Название',
                        'defaultValue' => null,
                        'options' => ['prompt' => 'Заполните']
                    ],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'title' => 'Описание',
                        'defaultValue' => null,
                        'options' => [
                            'prompt' => 'Заполните',
                            'rows' => '3'
                        ]
                    ],
                    [
                        'name' => 'main_stack',
                        'type' => 'dropDownList',
                        'title' => 'Основная технология',
                        'defaultValue' => null,
                        'items' => \yii\helpers\ArrayHelper::map(
                            \backend\modules\settings\models\Skill::find()->all(),
                            'id',
                            'name'
                        ),
                        'options' => ['prompt' => 'Выберите']
                    ],
                    [
                        'name' => 'additional_stack',
                        'type' => 'textInput',
                        'title' => 'Используемые технологии',
                        'defaultValue' => null,
                        'options' => ['prompt' => 'Заполните']
                    ],
                    [
                        'name' => 'link',
                        'type' => 'textInput',
                        'title' => 'Ссылка',
                        'defaultValue' => null,
                        'options' => ['prompt' => 'Заполните']
                    ],
                ],
            ])->label('Проекты в портфолио');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($model, 'fields')->widget(MultipleInput::class, [
                'cloneButton' => true,
                'columns' => [
                    [
                        'name' => 'field_id',
                        'type' => 'dropDownList',
                        'title' => 'Поле',
                        'defaultValue' => null,
                        'items' => \yii\helpers\ArrayHelper::map(
                            \backend\modules\settings\models\AdditionalFields::find()
                                ->joinWith('useFields')
                                ->where(['`use_field`.`use`' => \common\models\UseStatus::USE_PROFILE])
                                ->all(),
                            'id',
                            'name'
                        ),
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
                        'name' => 'order',
                        'title' => 'Приоритет',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                ],
            ])->label('Дополнительно');
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>