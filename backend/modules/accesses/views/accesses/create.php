<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Accesses */

$this->title = 'Добавить доступ';
$this->params['breadcrumbs'][] = ['label' => 'Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesses-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
