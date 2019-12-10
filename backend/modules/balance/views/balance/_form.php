<?php

use backend\modules\settings\models\AdditionalFields;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\Balance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')
        ->dropDownList(\common\models\Balance::getTypeList())?>

    <?= $form->field($model, 'summ')->textInput(['maxlength' => 9]) ?>

    <?php
    echo '<label> Выберите дату</label>';
    echo '<br>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'dt_add',
        'language' => 'ru',
        'dateFormat' => 'dd-MM-yyyy',
    ]);
    ?>

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
                            ->where(['`use_field`.`use`' => \common\models\UseField::USE_BALANCE])
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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
