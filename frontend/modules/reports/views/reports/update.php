<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = 'Редактировать отчет';
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->created_at, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="reports-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
