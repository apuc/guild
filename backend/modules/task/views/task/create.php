<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\task\models\ProjectTask */

$this->title = 'Создать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
