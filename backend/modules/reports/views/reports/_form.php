<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use Symfony\Component\Console\Input\Input;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $form yii\widgets\ActiveForm */

$this->registerCss('.list-cell__task{width:73%}')
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin();

    $now = time();
    $day = idate('d', $now);
    $month = idate('m', $now);
    $year = idate('Y', $now);
    $date = $year."-".$month."-".$day;

    if(!$model->created_at)
        $model->created_at = $date;
    echo '<b>Дата заполнения отчета:</b>';
    echo DatePicker::widget([
        'model' => $model,
        'language' => 'ru',
        'attribute' => 'created_at',
        'options' => [],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]).'<br>';
    ?>

    <?= $form->field($model, '_task')->widget(MultipleInput::class, [
                'cloneButton' => true,
                'max' => 10,
                'columns' => [
                    [
                        'name'  => 'task',
                        'title' => 'Задача',
                    ],
                    [
                        'name'  => 'hours_spent',
                        'title' => 'Кол-во часов',
                        'options' => [
                            'type' => 'number',
                            'style' => 'width:100px'
                        ],
                    ],
                    [
                        'name'  => 'minutes_spent',
                        'title' => 'Кол-во минут',
                        'options' => [
                            'type' => 'number',
                        ],
                    ],
                ],
            ])->label('Какие задачаи были выполнены:'); ?>

    <?= $form->field($model, 'difficulties')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'tomorrow')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_card_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(common\models\UserCard::find()->all(), 'id', 'fio'),
        ['prompt' => '...']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
