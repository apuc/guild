<?php

use mihaildev\ckeditor\CKEditor;
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
        'options' => ['method' => 'post']])
    ?>

    <?= $form->field($model, 'body')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ],
    ]); ?>

    <?php ActiveForm::end(); ?>

    <div>
        <p>
            <?= Html::a('Скачать pdf', ['download', 'id' => $model->id, 'fileType' => 'docx'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Скачать docx', ['download', 'id' => $model->id, 'fileType' => 'pdf'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>