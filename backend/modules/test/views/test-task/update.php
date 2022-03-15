<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\test\models\TestTask */

$this->title = 'Изменить тестовое задание';
$this->params['breadcrumbs'][] = ['label' => 'Test Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-task-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
