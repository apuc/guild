<?php
/**
 * @var $model \yii\db\ActiveRecord
 */
use yii\jui\DatePicker;

echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'dt_from',
    'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
    'options' => ['placeholder' => 'Выберите дату (От)'],
]);

echo " - ";

echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'dt_to',
    'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
    'options' => ['placeholder' => 'Выберите дату (До)'],
]);