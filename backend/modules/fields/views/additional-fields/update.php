<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\AdditionalFields */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Additional Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="additional-fields-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
