<?php


/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\TaskUser */
/* @var $task_id  */

$this->title = 'Назначить сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Task Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-user-create">

    <?= $this->render('_form', [
        'model' => $model,
        'task_id' => $task_id,
    ]) ?>

</div>
