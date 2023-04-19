<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectColumn */

$this->title = 'Создать колонку';
$this->params['breadcrumbs'][] = ['label' => 'Колонки проектов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-column-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
