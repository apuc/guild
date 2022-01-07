<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\TemplateDocumentField */

$this->title = 'Изменить поле документа';
$this->params['breadcrumbs'][] = ['label' => 'Template Document Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-document-field-update">

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
