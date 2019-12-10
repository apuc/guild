<?php

$this->title = 'Редактировать отпуск №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Список отпусков', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="holiday-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
