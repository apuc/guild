<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectUser */

$this->title = 'Изменить сотрудника на проекте';
$this->params['breadcrumbs'][] = ['label' => 'Project Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
