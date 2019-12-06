<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\notes\models\Note */

$this->title = 'Редактировать заметку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заметки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="notes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
