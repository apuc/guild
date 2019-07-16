<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\modules\company\models\Balance */

$this->title = 'Добавить отпуск';
$this->params['breadcrumbs'][] = ['label' => 'Список отпусков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>