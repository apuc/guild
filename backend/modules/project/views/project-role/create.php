<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\ProjectRole */

$this->title = 'Создать новую роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли сотрудников на проекте ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-role-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
