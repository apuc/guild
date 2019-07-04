<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\card\models\UserCard */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'User Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-card-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
