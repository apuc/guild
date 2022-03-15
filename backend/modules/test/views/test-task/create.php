<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\test\models\TestTask */

$this->title = 'Добавить тестовое задание';
$this->params['breadcrumbs'][] = ['label' => 'Test Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-task-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
