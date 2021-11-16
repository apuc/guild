<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\ManagerEmployee */

$this->title = 'Назначить работника';
$this->params['breadcrumbs'][] = ['label' => 'Manager Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-employee-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
