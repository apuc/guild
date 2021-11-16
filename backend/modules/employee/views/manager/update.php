<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\Manager */

$this->title = 'Изменить менеджера: ' . ArrayHelper::getValue($model,'user.username');
$this->params['breadcrumbs'][] = ['label' => 'Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manager-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
