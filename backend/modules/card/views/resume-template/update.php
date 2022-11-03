<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\ResumeTemplate */

$this->title = 'Изменить шаблон: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Resume Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resume-template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
