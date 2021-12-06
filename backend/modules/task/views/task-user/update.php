<?php


/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\TaskUser */
/* @var $task_id  */

$this->title = 'Изменить назначение';
$this->params['breadcrumbs'][] = ['label' => 'Task Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'task_id' => $task_id,
    ]) ?>

</div>
