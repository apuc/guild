<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectMark */

$this->title = 'Изменение метки для проекта: ' . $model->project->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-mark-update">

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
