<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\hh\models\HhJob */

$this->title = 'Create Hh Job';
$this->params['breadcrumbs'][] = ['label' => 'Hh Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hh-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
