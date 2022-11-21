<?php

use asmoday74\ckeditor5\EditorClassic;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */

$this->title = 'Документ: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Загрузить';
?>

<div class="form-group">
    <?= Html::a('Редактировать документ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Просмотр документа', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div

<div class="resume-form">

    <?php $form = ActiveForm::begin([
        'id' => 'update-resume-text-form',
        'action' => Url::to(['document/update-document-body', 'id' => $model->id]),
        'options' => ['method' => 'post']])
    ?>
        <?= $form->field($model, 'body')->widget(EditorClassic::className(), [
            'clientOptions' => [
                'language' => 'ru',
            ]
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохраниить изменения', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div>
        <p>
            <?= Html::a('Скачать pdf', ['download-pdf', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Скачать docx', ['download-docx', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>