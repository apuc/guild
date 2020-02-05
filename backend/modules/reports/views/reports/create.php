<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = 'Добавить отчет';
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
