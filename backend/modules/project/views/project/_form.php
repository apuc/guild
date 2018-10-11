<?php

use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

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
                        'items' => \yii\helpers\ArrayHelper::map(\backend\modules\fields\models\AdditionalFields::find()
                            ->joinWith('useFields')
                            ->where(['`use_field`.`use`' => \common\models\UseStatus::USE_PROJECT])
                            ->all(),
                            'id', 'name'),
                        'options' => ['prompt' => 'Выберите']
                    ],
                    [
                        'name'  => 'value',
                        'title' => 'Значение',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
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


    <?= $form->field($model, 'user')->widget(Select2::class,
        [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\UserCard::find()->all(),'id', 'fio'),
            'options' => ['placeholder' => '...','class' => 'form-control', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
