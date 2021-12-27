<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */

$this->title = 'Изменить Документ: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
