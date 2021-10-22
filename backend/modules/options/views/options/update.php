<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\options\models\Options */

$this->title = 'Редактировать опцию: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Опции', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ред.';
?>
<div class="options-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
