<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\interview\models\InterviewRequest */

$this->title = 'Update Interview Request: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Interview Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="interview-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
