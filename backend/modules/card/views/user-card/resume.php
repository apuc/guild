<?php

use asmoday74\ckeditor5\EditorClassic;
use backend\modules\card\models\ResumeTemplate;
use common\helpers\StatusHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = 'Резюме: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Профили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Резюме';
?>

<div class="form-group">
    <?= Html::a('Редактировать профиль', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Просмотр профиля', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>

<div class="resume-form">
    <?php $form = ActiveForm::begin([
        'id' => 'text-by-template-form',
        'action' => Url::to(['user-card/resume-text-by-template', 'id' => $model->id]),
        'options' => ['method' => 'post']])
    ?>
    <?= Html::hiddenInput('id', $model->id); ?>

    <?= $form->field($model, 'resume_template_id')->dropDownList(
        ResumeTemplate::find()->where(['status' => StatusHelper::STATUS_ACTIVE])->select(['title', 'id'])->indexBy('id')->column(),
        ['prompt' => 'Выберите'])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сгенерировать резюме по шаблону', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div class="resume-form">

    <?php $form = ActiveForm::begin([
        'id' => 'update-resume-text-form',
        'action' => Url::to(['user-card/update-resume-text', 'id' => $model->id]),
        'options' => ['method' => 'post']])
    ?>
        <?= $form->field($model, 'resume_text')->widget(EditorClassic::className(), [
            'clientOptions' => [
                'language' => 'ru',
            ]
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохраниить изменения', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="resume-form">
    <p>
        <?= Html::a('Скачать pdf', ['download-resume', 'id' => $model->id, 'type' => 'pdf'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Скачать docx', ['download-resume', 'id' => $model->id, 'type' => 'docx'], ['class' => 'btn btn-success']) ?>
    </p>
</div>