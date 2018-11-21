<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\hh\models\Hh */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'hh.ru', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hh-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
