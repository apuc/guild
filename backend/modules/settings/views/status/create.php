<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\status\models\Status */

$this->title = 'Добавить статус';
$this->params['breadcrumbs'][] = ['label' => 'Статусы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
