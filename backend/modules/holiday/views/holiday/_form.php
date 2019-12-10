<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm; ?>
<div class="holiday-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo \kartik\select2\Select2::widget([
            'model' => $model,
            'attribute' => 'card_id',
            'data' => \common\models\UserCard::getUserList(),
            'options' => ['placeholder' => 'Начните вводить...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]);
    ?>
    <?php
    echo '<label> Выберите дату начала отпуска</label>';
    echo '<br>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'dt_start',
        'language' => 'ru',
        'dateFormat' => 'dd-MM-yyyy',
    ]);
    echo '<br>';
    echo '<label> Выберите дату конца отпуска</label>';
    echo '<br>';
    echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'dt_end',
        'language' => 'ru',
        'dateFormat' => 'dd-MM-yyyy',
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
