<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTask */

$this->title = 'Исполнители задачи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
