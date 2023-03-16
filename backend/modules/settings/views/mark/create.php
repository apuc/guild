<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Mark */

$this->title = 'Создание метки';
$this->params['breadcrumbs'][] = ['label' => 'Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mark-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
