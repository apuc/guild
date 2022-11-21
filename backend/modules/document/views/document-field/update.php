<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentField */

$this->title = 'Изменить поле: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-field-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
