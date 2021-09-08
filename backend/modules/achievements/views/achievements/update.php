<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\achievements\models\Achievement */

$this->title = 'Редактировать достижение: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Заметки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="notes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
