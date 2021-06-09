<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\options\models\Options */

$this->title = 'Добавить опцию';
$this->params['breadcrumbs'][] = ['label' => 'Опции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="options-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
