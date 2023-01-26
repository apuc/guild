<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTaskCategory */

$this->title = 'Update Project Task Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Project Task Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-task-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
