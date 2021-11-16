<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\ManagerEmployee */

$this->title = 'Изменить сотрудника у менеджера:';
$this->params['breadcrumbs'][] = ['label' => 'Manager Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manager-employee-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
