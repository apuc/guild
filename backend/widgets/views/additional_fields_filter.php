<?php
/**
 * @var $model \yii\db\ActiveRecord
 */

echo \kartik\select2\Select2::widget(
    [
        'model' => $model,
        'attribute' => 'field_name',
        'data' => \common\models\Balance::getNameList(),
        'options' => ['placeholder' => 'Выбрать параметр','class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

echo \yii\helpers\Html::activeTextInput($model, 'field_value', [
    'placeholder' => 'Значение параметра'
]);