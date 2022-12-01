<?php

use backend\modules\company\models\Company;
use backend\modules\document\models\DocumentTemplate;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template_id')->widget(Select2::class,
        [
            'data' => DocumentTemplate::find()->select(['title', 'id'])->indexBy('id')->column(),
            'options' => ['placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <div>
        <p>Не обязательные поля:</p>
    </div>

    <?= $form->field($model, 'company_id')->dropDownList(
        Company::find()->select(['name', 'id'])->indexBy('id')->column(),
        [
            'id' => 'company-id',
            'prompt' => 'Выберите'
        ]
    );
    ?>

    <?= $form->field($model, 'manager_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'manager-id'],
            'pluginOptions' => [
                'depends' => ['company-id'],
                'placeholder' => 'Выберите',
                'url' => Url::to(['/document/document/managers'])
            ]
        ]
    ); ?>

    <?= $form->field($model, 'contractor_company_id')->widget(Select2::class,
        [
            'data' => Company::find()->select(['name', 'id'])->indexBy('id')->column(),
            'options' => ['id' => 'contractor-company-id','placeholder' => '...','class' => 'form-control'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'contractor_manager_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'contractor-manager-id'],
            'pluginOptions' => [
                'depends' => ['contractor-company-id'],
                'placeholder' => 'Выберите',
                'url' => Url::to(['/document/document/managers']),
                'params' => ['contractor-company-id']
            ]
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
