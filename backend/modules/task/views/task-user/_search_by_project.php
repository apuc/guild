<?php

use backend\modules\project\models\Project;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\TaskUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'projectId')->widget(Select2::className(),[
        'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
        'options' => ['placeholder' => 'Выберите проект'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Проект') ?>


    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>