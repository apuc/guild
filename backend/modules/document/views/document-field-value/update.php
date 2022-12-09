<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentFieldValue */
/* @var $fromDocument bool */

$this->title = 'Изменить значение поля документа: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Document Field Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-field-value-update">

    <?= $this->render('_form', [
        'model' => $model,
        'fromDocument' => $fromDocument
    ]) ?>

</div>
