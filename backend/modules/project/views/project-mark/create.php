<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectMark */

$this->title = 'Добавление проекту метки';
$this->params['breadcrumbs'][] = ['label' => 'Project Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-mark-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
