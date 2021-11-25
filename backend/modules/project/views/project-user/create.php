<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectUser */

$this->title = 'Назначить сотрудника на проект';
$this->params['breadcrumbs'][] = ['label' => 'Project Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
