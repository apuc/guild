<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\CompanyManager */

$this->title = 'Добавить нового менеджера компании';
$this->params['breadcrumbs'][] = ['label' => 'Company Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-manager-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
