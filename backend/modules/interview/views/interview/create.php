<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\interview\models\InterviewRequest */

$this->title = 'Create Interview Request';
$this->params['breadcrumbs'][] = ['label' => 'Interview Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interview-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
