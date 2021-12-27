<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */

$this->title = 'Изменение значения поля документа';
$this->params['breadcrumbs'][] = ['label' => 'Document Field Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-field-value-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
