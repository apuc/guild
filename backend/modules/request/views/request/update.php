<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\request\models\Request */

$this->title = 'Редактировать запрос: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Запросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ред.';
?>
<div class="request-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
