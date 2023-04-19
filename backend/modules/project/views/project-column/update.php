<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectColumn */

$this->title = 'Редактировать колонку: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Колонки проектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="project-column-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
