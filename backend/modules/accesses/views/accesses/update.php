<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accesses */

$this->title = 'Редактировать доступ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Доступы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="accesses-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
