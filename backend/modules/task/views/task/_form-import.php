<?php

use backend\modules\project\models\Project;
use common\models\forms\TasksImportForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model  TasksImportForm*/
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Импорт задач';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-index">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companyId')->dropDownList(\common\models\Company::find()
        ->select(['name', 'id'])->indexBy('id')->column(),
        [
            'prompt' => 'Выберите'
        ]
    );

    ?>

    <?= $form->field($model, 'userId')->widget(
        Select2::class,
        [
            'data' => \common\models\UserCard::getListUserWithUserId(),
            'options' => ['placeholder' => '...', 'class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'projectId')->widget(
        Select2::class,
        [
            'data' => Project::find()->select(['name', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...', 'class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'fromDate')->widget(DatePicker::class,[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>


    <?= $form->field($model, 'toDate')->widget(DatePicker::class,[
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Импорт', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
