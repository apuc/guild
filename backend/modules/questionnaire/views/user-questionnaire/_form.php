<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\modules\questionnaire\models\UserQuestionnaire */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelCategory backend\modules\questionnaire\models\QuestionnaireCategory */
?>

<div class="user-questionnaire-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelCategory, 'title')
        ->dropDownList($modelCategory->getIdTitlesArr(),
            [
                'id' => 'cat-id',
                'prompt' => 'Выберите'
            ]
        );
    ?>

    <?= $form->field($model, 'questionnaire_id')->widget(DepDrop::className(),
        [
            'options' => ['id' => 'questionnaire-id'],
            'pluginOptions' => [
                'depends' => ['cat-id'],
                'placeholder' => 'Выберите',
                'url' => Url::to(['/questionnaire/user-questionnaire/questionnaire'])
            ]
        ]
    ); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class,
        [
            'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(),'id', 'username'),
            'options' => ['placeholder' => 'Выберите пользователя','class' => 'form-control'],
            'pluginOptions' => [
                'placeholder' => 'Выберите',
                'allowClear' => true
            ],
        ]
    ); ?>

    <?= $form->field($model, 'status')->dropDownList(
        \common\helpers\StatusHelper::statusList(),
        [
            'prompt' => 'Выберите'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
