<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\employee\models\Manager */

$this->title = 'Назначить менеджера';
$this->params['breadcrumbs'][] = ['label' => 'Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
