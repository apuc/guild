<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\CompanyManager */

$this->title = 'Изменить менеджера компании: ' . $model->userCard->fio;
$this->params['breadcrumbs'][] = ['label' => 'Company Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-manager-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
