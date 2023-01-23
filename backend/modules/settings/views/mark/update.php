<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Mark */

$this->title = 'Изменение метки: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mark-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
