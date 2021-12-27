<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\TemplateDocumentField */

$this->title = 'Добавить в шаблон поле';
$this->params['breadcrumbs'][] = ['label' => 'Template Document Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-document-field-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
