<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTaskCategory */

$this->title = 'Создание категории задач';
$this->params['breadcrumbs'][] = ['label' => 'Project Task Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-task-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
