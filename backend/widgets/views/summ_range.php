<?php
/**
 * @var $model \yii\db\ActiveRecord
 */

echo \yii\helpers\Html::activeTextInput($model, 'summ_from', [
    'placeholder' => 'От',
]);
echo ' - ';
echo \yii\helpers\Html::activeTextInput($model, 'summ_to', [
    'placeholder' => 'До',
]);