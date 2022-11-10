<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\DocumentTemplate */

$this->title = 'Изменить шаблон: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
